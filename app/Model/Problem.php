<?php
App::uses('AppModel', 'Model');
/**
 * TargetKnowledge Model
 *
 */
class Problem extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	);

/**
 * 問題情報取得関数
 * @param int $year 出題年度
 * @param int $grade 出題級 
 * @return json[] $problems 問題情報
 */
    public function getProblemsData($year, $grade){
        $url = "http://sakumon.jp/app/maker/moridai/pasttest/".$grade."/".$year.".json";
		$problems = json_decode(file_get_contents($url), true);

        return $problems;        
    }

/**
 * 問題情報整理関数
 * 問題情報を整理して問題文，正答，誤答のみにする
 * 不要なスペース，改行の削除，数値の半角化も行う
 * @param string[] $data 問題情報
 * @return string[] $result 問題文、正答、誤答の問題情報
 */
    public function getOrderProblem($data){
        $sn_pattern = '/\s|\n/u';
        $result['sentence'] = mb_convert_kana($data['question'], 'n'); // 問題文(数値を半角に)
        // スペース，改行の削除
        $result['sentence'] = preg_replace($sn_pattern, '', $result['sentence']);
        // 多肢選択式か一問一答式か
        if ($data['format'] === 'multiple-choice'){
            for ($i = 1, $j = 1; $i <= 4; $i++){
                if ($data['right_answer'] == $i){
                    $result['right_answer'] = mb_convert_kana($data['option'.$i], 'n');
                    $result['right_answer'] = preg_replace($sn_pattern, '', $result['right_answer']);
                }else{
                    $result['wrong_answer'.$j] = mb_convert_kana($data['option'.$i], 'n');
                    $result['wrong_answer'.$j] = preg_replace($sn_pattern, '', $result['wrong_answer'.$j]);
                    $j++;
                }
            }
        }else{
            $result['right_answer'] = mb_convert_kana($data['right_answer'], 'n');
            $result['right_answer'] = preg_replace($sn_pattern, '', $result['right_answer']);
        }

        return $result;
    }

/**
 * 問題情報変換モジュール
 * @param string[] $problem 問題情報
 * @param int $year 出題年度
 * @param int $grade 出題級
 * @return string[] $result 変換済みの問題情報, 出題パターン
 */
    public function convertProblem($problem, $year, $grade){ 
        // 出題パターン判定
        $patternId = $this->getProblemPattern($problem);
        // 文字列置換
        $problem['sentence'] = $this->getReplacePreg($problem['sentence'], $year);

        // パターン情報を格納
        App::import('Model', 'Pattern');
        $this->Pattern = new Pattern; 
        $patterns = $this->Pattern->find('first', array('conditions' => array('id' => $patternId)));

        // 出題パターンに沿って問題情報から各要素を抽出
        $result['knowledge'] = $this->getKnowledgeElements($problem, $patterns['Pattern']);
        // 出題パターンを追加格納
        $result['Pattern'] = array('id' => $patterns['Pattern']['id'], 'name' => $patterns['Pattern']['name']);

        return $result;
    }

/**
 * 文字列置換関数
 * @param string $data 問題文
 * @param int $year 出題年度
 * @return string $result 文字列置換済みの問題文
 */
    public function getReplacePreg($data, $year){
        /* 文字列置換
         * 以下の文字列を含む問題文があった場合、置換を行う
         * "今年": $year."年"
         * "現在": $year."年現在"
         * "来年": $year + 1."年"
         * "去年": $year - 1."年"
         * "昨年": $year - 1."年"
         */
        $searchstr = array('今年', '現在', '来年', '去年', '昨年');
        $replacestr = array($year.'年', $year.'年現在', ($year+1).'年', ($year-1).'年', ($year-1).'年');
        $result = str_replace($searchstr, $replacestr, $data); 
        // 重複置換確認
        // 上記だけだと例えば2013年現在という文字列があった場合2013年2013年現在になってしまうので、もとに戻す
        $result = preg_replace('/[0-9]{4}年[0-9]{4}年現在/u', $year.'年現在', $result);

        /* 文末削除
         * ここは適宜追加していく他、将来的には文末テーブル作ってユーザに文末を決めてもらうと汎用性あがるかも
         */
        $preg = array(
            '/(何.?|なに.?|どれ|どこ|誰|だれ|もの|どのあたり)?(ですか|でしたか)。?$/u',
            '/(何.*と言|なん.*と言|何.*とい|なん.*とい|何.*と言われて|なん.*と言われて|何.*といわれて|なん.*といわれて|何.*と呼ばれて|なん.*と呼ばれて|何.*とよばれて|なん.*とよばれて|されて|に?あり|に?あたり|に?なり|つき|かかり)?(い?ますか|い?ましたか)。?$/u',
            '/を?書きなさい。?$/u',
            '/(次|つぎ)の(内|うち|中|なか)の/u',
        );
        $result = preg_replace($preg, "", $result);
        $result = preg_replace('/書きなさい。?$/u', "", $result); // 上記以外の場合（記述式問題）文末を削除

        return $result;
    }


    /**
     * 問題の出題パターン判定関数
     * @param string[] $data 問題の配列
     * @return string $result 出題パターンID
     */
    public function getProblemPattern($data){
        $result = '';

        // MecabにWikipediaの辞書読み込ませる（名詞の判定）
        ini_set('mecab.default_userdic', '/usr/local/Cellar/mecab/0.996/lib/mecab/userdic/wiki_hatena.dic');
        $mecab = new Mecab_Tagger();
        $nodes_s = $mecab->parseToNode($data['sentence']);
        $nodes_r = $mecab->parseToNode($data['right_answer']);
        if (isset($data['wrong_answer1'])){
            $nodes_w1 = $mecab->parseToNode($data['wrong_answer1']); 
            $nodes_w2 = $mecab->parseToNode($data['wrong_answer2']);    
            $nodes_w3 = $mecab->parseToNode($data['wrong_answer3']);    
        }

        // 1. 読み方を答える問題表現とのマッチ
        $pattern = '/読み|何と.*よみ|よみかた|よみ方/u';
        if (preg_match($pattern, $data['sentence']) === 1){
            $result = 'Ph';  
        }else if (preg_match('/方言|盛岡弁/u', $data['sentence']) === 1){ // 方言の問題
            if (preg_match('/「/u', $data['sentence']) === 1 || preg_match('/意味/u', $data['sentence']) === 1){
                $result = "Pa+"; // 方言の意味を問う問題の場合
            }else{
                $result = "Pf"; // 方言を答える問題
            }
        }else{
            $flg = 0;
            // 否定的表現
            $deny_pattern1 = '/(では?|正しくは?|あたら|当てはまら|含まれて?|てい|に)(ない|無い)/u';
            $deny_pattern2 = '/(に?なかった|誤って|誤り|間違って)/u';
            // 2. 単名詞か複合名詞のみが正答に存在するか（flg = 0のときは存在する)
            foreach($nodes_r as $node){
                $partos = explode(',', $node->getFeature());
                if (($node->getLength() != 0 && $partos[0] !== "名詞") || preg_match('/.*[0-9].*/u', $node->getSurface()) === 1){
                    $flg = 1;
                    break;
                }
            }
            // 3. 正答・誤答全てに数値が存在する
            // あるいは記述式問題で正答に数値があるとき
            if ($flg === 1){
                foreach($data as $key => $value){
                    $num_flg = 0; // 0のときは数値のみ
                    if ($key === "right_answer" || preg_match('/^wrong_answer[1-3]/u', $key) === 1){
                        if (preg_match('/.*[0-9].*/u', $value) === 0){
                            $num_flg = 1;
                            break;
                        }
                    }
                } 
                if (!isset($data['wrong_answer1'])){ // 記述式問題の場合
                    if ($num_flg == 0 && preg_match('/いつですか/u', $data['sentence']) === 0){ // 正答に数値が含まれていても、日付を聞いていない場合は数値問題として扱わない
                        $num_flg = 1;
                    } 
                }
                if ($num_flg == 1){ // 数値以外が存在
                    // ここで問題文に否定的表現がある場合はPa-になる
                    if (preg_match($deny_pattern1, $data['sentence'] === 1 || preg_match($deny_pattern2, $data['sentence'] === 1))){
                        $result = 'Pa-';
                    }else{
                        $result = 'Pa+'; // もしくはPc+(両者の判別は不可)
                    }
                }else{ // 数値のみが存在
                    $result = 'Pg';
                }
            }else if(preg_match($deny_pattern1, $data['sentence'] === 1 || preg_match($deny_pattern2, $data['sentence'] === 1))){
            // 4. 否定的表現とマッチしているか
                $result = 'Pb-'; // もしくはpd-(両者の判別は不可)
            }else{
                $piflg = 0; // 0のときはPi+ではない
                // 5. 正答・誤答に単名詞か複合名詞が2つずつ存在
                if (isset($data['wrong_answer1'])){ // 記述式問題の場合は飛ばす
                
                    /* 組み合わせの問題判定(条件は以下のAnd）
                     * ・問題文に「組み合わせ」という文字列がある
                     * ・正答，誤答全てに名詞が存在する
                     * もしかしたら組み合わせは対象外にするかも
                    */
                    if (preg_match('/組み合わせ/u', $data['sentence'] === 1)){
                        $name_flg = 0; // 各選択肢に名詞が存在するごとにカウントアップ. 4にならない場合は名詞が存在しない選択肢がある
                        $ans_nodes = array($node_r, $node_w1, $node_w2, $node_w3); // 正答・誤答のnodeをまとめる

                        for ($i = 0; $i < 4; $i++){
                            foreach($ans_nodes[$i] as $node){
                                $feature = explode(',', $node->getFeature());
                                if ($feature === "名詞"){
                                    $name_flg++;
                                    break;
                                } 
                            }
                        } 
                        if ($name_flg == 4) $piflg = 1;
                    }
                }
                if ($piflg == 1){
                    $result = 'Pi+';
                }else{
                    // 6. 正答が人名
                    // 人名かを判断するためにユーザ辞書の設定を消してMecabをやり直す
                    $human_flg = 0; // 1になったら人名
                    ini_set('mecab.default_userdic', '');
                    $sys_mecab = new Mecab_Tagger();
                    $sys_nodes_r = $sys_mecab->parseToNode($data['right_answer']);
                    foreach($sys_nodes_r as $sys_node){
                        $sys_feature = explode(',', $sys_node->getFeature());
                        foreach($sys_feature as $value){
                            if ($value === "人名"){
                               $human_flg = 1; 
                            }
                        }
                        if ($human_flg == 1) break;
                    }
                    if ($human_flg == 1){
                        $result = 'Pf';
                    }else{
                        // 7. 正答が盛岡独自の用語
                        /*
                         * 盛岡独自の用語は以下の通り
                         * - 「盛岡」,「岩手」が含まれている
                         * - Wikipediaの記事名とヒットした場合記事に「盛岡」があるもの
                         * - 寺, 神社, 山,橋, 学校, 高校, 大学が正答に含まれている
                         * - 問題文に、施設,町の?名, 地域, 老舗が含まれている  
                         * ここも将来的にはユーザに決めてもらうと汎用性高いかな
                         */
                        
                        // まずはパターンマッチングを行う
                        $pattern_s = '/盛岡|岩手|施設|[町街]の?名|地域|老舗/u';
                        $pattern_r = '/盛岡|岩手|寺$|神社$|山$|橋$|学校|高.*校|大学/u';

                        if (preg_match($pattern_s, $data['sentence']) === 1 || preg_match($pattern_r, $data['right_answer']) === 1){
                            $result = 'Pf';
                        }else{
                            // Wikipediaの記事参照
                            // MecabデータからWikipediaで抽出されたものを取得
                            foreach($nodes_r as $node){
                                $wiki_f = explode(',', $node->getFeature());
                                foreach($wiki_f as $value){
                                    if ($value === 'wikipedia'){
                                        // Wikipediaのアブストを参照
                                        $getwiki = $this->getWikiAbstract($node->getSurface()); 
                                        if ($getwiki){ // trueのときは独自の用語となる
                                            $result = 'Pf';
                                            break;
                                        }
                                    }
                                }
                                if ($result === 'Pf') break;
                            }
                            if ($result !== 'Pf') $result = 'Pd+';
                        }
                    }
                }
            }
        }
        return $result;
    }

/**
 * WikipediaのAbstractを参照して「盛岡市」があるかを判断
 * 今回はAbstractのみを用いるのでDBPediaを使う
 * 
 * @param string $word 参照するページ名
 * @return boolean $result 「盛岡市」があるかないか
 */
    public function getWikiAbstract($word){
        $format = 'json'; // DBpediaからのレスポンスフォーマット指定  
        $result = '';

        // DBPediaに投げるクエリ文
        $query = "select distinct * where { <http://ja.dbpedia.org/resource/".$word."> <http://dbpedia.org/ontology/abstract> ?o . }";

        // 発行URL
        $url = 'http://ja.dbpedia.org/sparql?query='.urlencode($query).'&format='.$format;

        // クエリ発行
        // curlがあるか
        if (!function_exists('curl_init')){
            die('CURL is not installed!');
        }
        // Curlセッションを初期化
        $ch= curl_init();
        // リクエストURLをセット
        curl_setopt($ch, CURLOPT_URL, $url);
        // 結果を文字列で取得
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // curlの実行
        $response = curl_exec($ch);

        curl_close($ch);

        // パターンマッチング
        $responseArray = json_decode($response, true);
        if (isset($reponseArray['results']['bindings'][0]['o']['value'])){
            $resAbst =  $reponseArray['results']['bindings'][0]['o']['value'];
            if (preg_match('/盛岡市/u', $resAbst) === 1) $result = true;
            else $result = false;
        }else $result = false; 

        return $result;
    }

/**
 * 問題情報から知識ベースの各要素を出題パターンに沿って抽出する関数
 *
 * @param string[] $problem 問題情報
 * @param string[] $pattern 出題パターン
 * @return string[] $result 知識ベースの各要素に変換済みの問題情報
 */
    public function getKnowledgeElements($problem, $pattern){
        $result = ''; // 結果用変数
        $column_name = array('sentence', 'right_answer', 'wrong_answer1', 'wrong_answer2', 'wrong_answer3'); // Problemの要素名と対応
        foreach($pattern as $key => $value){
            $col = preg_match('/(?<=appeared_).*/u', $key, $m);
            if ($col === 1){ // appeard_が含まれている場合
                $res_cname = ''; // カラム名
                if ($m[0] === 'property'){ // propertyのとき
                    $res_cname = 'properties';
                    if ($value == 1){ // 問題文の場合は句読点で分割
                        $result[$res_cname] = preg_split('/[、。,.，．]/u', $problem[$column_name[$value - 1]]);
                    }
                }else{ // 対象知識かオブジェクトの場合
                    preg_match('/.*[^0-9]/u', $m[0], $resm); // 数字を削除
                    $res_cname = $resm[0].'s'; // カラム名を複数形にして格納
                    if ($value == 1){ // 問題文の場合は用語抽出
                        $result[$res_cname][] = $this->yahoo($problem[$column_name[$value - 1]]); 
                    }
                } 
                if ($value == 2 || $value == 3){ // 正答と誤答のとき
                    $result[$res_cname][] = $problem[$column_name[$value - 1]]; // $valueは1からはじまる
                    if ($value == 3){ // 誤答の場合
                        $result[$res_cname][] = $problem[$column_name[$value]]; // 誤答の残り2つも格納
                        $result[$res_cname][] = $problem[$column_name[$value + 1]]; 
                    }
                }
            }
        }
        return $result;
    }

/**
 * Yahooキーフレーズ抽出APIを用いたキーワード抽出関数
 *
 * @param string $sentence 問題文
 * @return string $result 抽出されたキーワード
 */
    public function yahoo($sentence){
        $appid = 'dj0zaiZpPWxPaEZXa2tJV2FqMCZzPWNvbnN1bWVyc2VjcmV0Jng9YzA-';
        $output = 'json';
        $request  = "http://jlp.yahooapis.jp/KeyphraseService/V1/extract?";
        $request .= "appid=".$appid."&sentence=".urlencode($sentence)."&output=".$output;
        
        $result = json_decode(file_get_contents($request), true);
        reset($result); // array('keyword' => score)の形式で重要度順に返ってくるので最初の要素名を取得する
        $result = key($result);
        
        return $result;
    }
}
