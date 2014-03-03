ESelect2 is a widget extension for Yii framework. This extension is a wrapper for Select2 Jquery plugin ([https://github.com/ivaynberg/select2][1]).

## Requirements ##

 - Yii 1.1 or above (tested on 1.1.10)

## Usage ##

 - Extract the downloaded file to your application extensions directory
 - Use it at your view

## Examples ##

Basic
-----
```php
$this->widget('ext.select2.ESelect2', array(
 'name' => 'selectInput',
	'data' => array(
		0 => 'Nol',
		1 => 'Satu',
		2 => 'Dua',
	)
));
```
Working with model
------------------
```php
$this->widget('ext.select2.ESelect2', array(
	'model' => $model,
	'attribute' => 'attrName',
	'data' => array(
		0 => 'Nol',
		1 => 'Satu',
		2 => 'Dua',
	),
));
```
Using selector
--------------
```php
$tags = array('Satu', 'Dua', 'Tiga');
echo CHtml::textField('test', '', array('id' => 'test'));
$this->widget('ext.select2.ESelect2', array(
	'selector' => '#test',
	'options' => array(
		'tags' => $tags,
	),
));
```
Using `optgroup`
----------------
```php
$data = array(
	'one' => array(
		'1' => 'Satu',
		'2' => 'Dua',
		'3' => 'Tiga',
	),
	'two' => array(
		'4' => 'Sidji',
		'5' => 'Loro',
		'6' => 'Telu',
	),
	'three' => array(
		'7' => 'Hiji',
		'8' => 'Dua',
		'9' => 'Tilu',
	),
);

$this->widget('ext.select2.ESelect2', array(
	'name' => 'testing',
	'data' => $data,
));
```
Multiple data
-------------
```php
$data = array(
	'1' => 'Satu',
	'2' => 'Dua',
	'3' => 'Tiga',
);

$this->widget('ext.select2.ESelect2', array(
	'name' => 'ajebajeb',
	'data' => $data,
	'htmlOptions' => array(
		'multiple' => 'multiple',
	),
));
```
Placeholder
-----------
```php
$this->widget('ext.select2.ESelect2', array(
	'name' => 'asik2x',
	'data' => $data,
	'options' => array(
		'placeholder' => Yii::t('select2', 'Keren ya?'),
		'allowClear' => true,
	),
));
```
Working with remote data
------------------------
```php
echo CHtml::textField('movieSearch', '', array('class' => 'span5'));
$this->widget('ext.select2.ESelect2', array(
	'selector' => '#movieSearch',
	'options' => array(
		'placeholder' => 'Search a movie',
		'minimumInputLength' => 1,
		'ajax' => array(
			'url' => 'http://api.rottentomatoes.com/api/public/v1.0/movies.json',
			'dataType' => 'jsonp',
			'data' => 'js: function(term,page) {
					return {
						q: term, 
						page_limit: 10,
						apikey: "e5mnmyr86jzb9dhae3ksgd73" // Please create your own key!
					};
				}',
			'results' => 'js: function(data,page){
				return {results: data.movies};
			}',
		),
		'formatResult' => 'js:function(movie){
			var markup = "<table class=\"movie-result\"><tr>";
			if (movie.posters !== undefined && movie.posters.thumbnail !== undefined) {
				markup += "<td class=\"movie-image\"><img src=\"" + movie.posters.thumbnail + "\"/></td>";
			}
			markup += "<td class=\"movie-info\"><div class=\"movie-title\">" + movie.title + "</div>";
			if (movie.critics_consensus !== undefined) {
				markup += "<div class=\"movie-synopsis\">" + movie.critics_consensus + "</div>";
			}
			else if (movie.synopsis !== undefined) {
				markup += "<div class=\"movie-synopsis\">" + movie.synopsis + "</div>";
			}
			markup += "</td></tr></table>";
			return markup;
		}',
		'formatSelection' => 'js: function(movie) {
			return movie.title;
		}',
	),
));
```

## Resources ##

 - Jquery extension URL:
 - [https://github.com/ivaynberg/select2][2]
 - Demo [http://ivaynberg.github.com/select2/][3]
 - Yii extension URL:
 - [http://www.yiiframework.com/extension/select2/][5]
 - [https://github.com/anggiaj/ESelect2][5]


  [1]: https://github.com/ivaynberg/select2
  [2]: https://github.com/ivaynberg/select2
  [3]: http://ivaynberg.github.com/select2/
  [4]: http://www.yiiframework.com/extension/select2/
  [5]: https://github.com/anggiaj/ESelect2
