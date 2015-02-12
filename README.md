# KnowledgeBase
検定・資格試験などの過去問題を体系化するシステム。
問題情報から対象知識、カテゴリ、プロパティ、オブジェクトを抽出して知識ベース化する


## システム方針

1. 問題の登録(作問)は行わない
 - あくまでも既存の問題から知識ベースを構築するためのシステムであるので、作問機能はない。
 - 作問はもりけんWebやもりけんAppなどで行い、それらのアプリで登録された問題を体系化するためのシステムが本システムである。
2. 知識ベースへの登録方法
 - 問題リスト(過去問題リストとオリジナル問題を提供)から1問選んで知識ベースに登録する。
 - 今後リストの問題をまとめて登録出来るようにする予定。

## 体系化手法におけるルール一覧
### 数値を答える問題の識別

- 正答・誤答全てに数値が含まれている（選択式問題の場合）
- 「いつですか」が問題文に含まれており、かつ正答に数値が存在する（記述式問題の場合）
- 現段階において記述式問題は日付を答える問題のみに対応している

###  否定パターンリスト（記述式問題は否定パターンなしとみなす）

- になかった（呉服町になかった銀行はどれですか）
- ものでない|無い（設立したものでないのは）
- 正しくないのは（正しくないのはどれですか）
- では？ないもの（残した事業でないものはどれですか）
- てい？ない（接していない市はどこですか）
- 誤っているも?の（誤っているものはどれですか）
- 間違っているも？のは（間違っているのはどれですか）
- あたらない（記念の年にあたらない出来事はどれですか）
- 当てはまらない（当てはまらないものはどれですか）
- 含まれ（てい）？ないもの（含まれないものはどれですか）

### カテゴリの判断（上から優先度高、条件分岐）

- WikipediaOntologyのHyperから取得
- WikipediaOntologyのTypeから取得（複数の場合は最初のにするか選ばせる）
- DBPediaから記事に付与されているカテゴリを取得
 - 盛岡市の〜，岩手県の〜，日本の〜に該当するもの（盛岡市の〜を優先）

## 更新履歴




#### 未実装機能（今後の予定）

- カテゴリの選定（getCategoriesメソッド）
 - カテゴリ決定モジュールの上位カテゴリ決定（WordNetを用いる）
 - カテゴリ決定モジュールでWikipediaにデータがないときの処理
- カテゴリ一覧機能
 - View画面でそのカテゴリの問題一覧取得（対象知識のViewと同じ）
- カテゴリ登録機能
 - 親カテゴリがないときのSave（belongsToのChildCategoryを使う）
- カテゴリの複数表示（親カテゴリの登録に成功していないため）

#### bugfixes
- 各要素を複数登録した場合，どれか一つが重複してるときの処理
- 対象知識が複数のときに対象知識一覧に両方出てしまう
