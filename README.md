# Widgets
**The package is in development now!!!**

This is the simple Widgets package for Laravel. It allows to create interface elements using OOP.
***
HtmlWidget
-----------------------------------
It is the widget for creating HTML.

###Generating tags
To generate HTML tag you should to call method _tag()_ of the _HtmlWidget_ class:
```php
HtmlWidget::tag('p');
```
And then we`ll get this HTML:
```html
<p></p>
```

The _tag()_ can get config array which allow to add some attributes and values:
```php
HtmlWidget::tag('button',[
    'params' => [
        'class' => 'btn',
    ],
    'value' => 'Ok',
]);
```
The result HTML:
```html
<button class="btn">Ok</button>
```

####Composite tags

The Widgets return the string value which belong to integrated Laravel class Illuminate\Support\HtmlString. And then
You can place the Widget to value of another Widget. For example:
```php
{{HtmlWidget::tag('form', [
        'params' => [
            'class' => 'form-inline',
            'method' => 'post',
            'action' => '/users/login',
            'enctype' => 'multipart/form-data',
        ],
        'value' => csrf_field().
                   HtmlWidget::tag('input', [
                       'params' => [
                           'name' => 'password',
                       ]
                   ]).
                   HtmlWidget::tag('button', [
                       'params' => [
                            'type' => 'submit',
                            'class' => 'btn',
                       ],
                       'value' => 'Login'
                   ]),
])}}
```

The result HTML:
```html
<form class = "form-inline"
      method = "post"
      action = "/users/login"
      enctype = "multipart/form-data">
    <input type="hidden" name="_token" value="tocken will be here">
    <input name = "password"></input>
    <button type = "submit" class = "btn">Login</button>
</form>
```
As you may have noticed the Widgets are connected by a concatenation sign '.'. 

####Simple tags

If you don`t want to make the closed tag or It is unprofitably for you to use the composite tags you can give the _false_ 
argument to the method:
```php
{{HtmlWidget::tag('form', [
    'params' => [
        ...
        ...
    ], 
],false)}}
@csrf
...
...
{{HtmlWidget::tag('/form')}}
```
***
TableWidget
-----------------------------------
This Widget allow to create the table using yours models and collections. The Widget is very simple and flexible. It 
doesn`t restrict you by Laravels models and collections to giving you opportunity to use your own objects.
To create the table use method _table()_:
```php
{{TableWidget::table([
    'params' => [
        'class' => 'table  table-striped',
    ],
    'columns' => [
        'id',
        'status',
        'error_message',
        'event',
    ],
], $collection)}}
```
To generate the table you should to pass the collections properties to the config array. The columns will be named as 
these properties:
```html
<table class = "table  table-striped">
    <thead>
        <tr>
            <th>id</th>
            <th>status</th>
            <th>error_message</th>
            <th>event</th>
        </tr>
    </thead>
    <tbody>
    ...
    Your collections values
    ...
    </tbody>
```
If you want to name your column otherwise, you can do it:
```php
{{TableWidget::table([
    'columns' => [
        'id',
        'status',
        [
            'label' => 'Error',
            'attribute' => 'error_message',
        ],
        'event',
    ],
], $collection)}}
```
You can also add any string instead of an attribute or even string which will containing an attribute. This is 
especially useful if you want to use some widget inside the table.
To do that you should to use _value_ instead of _attribute_ and pass the array _value => [(string)$value, 
(array)$attributes]_. The dynamic variable you write like this: _.'attribute'_.   
Look for example:
```php
{{TableWidget::table([
    'columns' => [
        [
            'label' => '',
            'value' => [
                HtmlWidget::tag('input', [
                    'params' => [
                        'type' => 'checkbox',
                        'value' => ".'id_value'"
                    ]
                ]),
                [
                    'id_value' => 'id',
                ]
            ]
        ],
        'status',
        [
            'label' => 'Error',
            'attribute' => 'error_message',
        ],
        'event',
    ],
], $collection)}}
```