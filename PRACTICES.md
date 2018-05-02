# Best practices

- [Project Structure](#project-structure)
  - [Project Structure: Routes](#project-structure_routes)
  - [Project Structure: Services](#project-structure_services)
  - [Project Structure: Views](#project-structure_views)
- [Javascript](#javascript)

<a name="project-structure">
## Project structure
</a>

In general, try to group like-things by feature instead of (or in addition to) grouping by file type. Grouping by file type is nice in small structures, bu quickly becomes hard to maintain.

For instance, take `app/Http/Requests`. Having them all in the top-level of that directory works, but if there are 12 Models with 2 or 3 operations each (e.g. Store, Update), then there are 24-36 classes in one directory. Grouping them as `.../Tag/Update` and `.../Tag/Store` instead of `.../StoreTag` and `.../UpdateTag` will make things easier to find.

<a name="project-structure_routes">
### Routes
</a>

Standard routing example:  
- Route::get('/model', 'ModelController@index');
- Route::get('/model/create', 'ModelController@create');
- Route::post('/model', 'ModelController@store');
- Route::get('/model/all', 'ModelController@all');
- Route::get('/model/{id}', 'ModelController@show');
- Route::get('/model/{id}/edit', 'ModelController@edit');
- Route::post('/model/{id}', 'ModelController@update');
- Route::post('/model/{id}/action', 'ModelController@action');
- Route::get('/admin/model', 'Admin/ModelController@index');

<a name="project-structure_services">
### Services
</a>

_In progress_

<a name="project-structure_views">
### Views
</a>

The group-by-feature idea applies here, especially. Rather than grouping all forms (of which there will be many) under `views/components`, try grouping into `views/{module}/components`. It's nice to also try to create common, anticipated components for each module, like a `form` (maybe even separate `form/edit` and `form/create`), a `list-item`, etc.

<a name="javascript">
## Javascript
</a>

### Encapsulate into "libraries" of objects with functions

Specifics change: URLs, DOM element IDs, etc. For the most part, the general ideas live on. Write a function that lives in an encapsulated parent object, give it a good name, and use it in your event handlers and in more complex functions.

For example, to get a list of Leagues asynchronously, try:

```
League.getAll = function () {
    return $.ajax({
        'type': 'GET',
        'url': '/league/all',
        'data': {}
    });
}
```

Not only is `League.getAll()` simpler to write than the fill jQuery object, it's also chainable and doesn't change if the API endpoint switches to `GET /league/get-all`.

### Rather than hard-code, include flexible identifiers

For example, when making an autocomplete component, don't hard-code the ID of the target input that ultimately sets the form state. Rather, give all autocompletes a `target-input-id` attribute.

_View_
```
<input id="parent-organization-id" type="hidden" name="parent_organization_id" />
<input id="parent_organization" name="parent_organization" type="text" class="organization-autocomplete" target-input-id="parent-organization-id" />
```
_JS_
```
var organization_autocomplete = $('input.organization-autocomplete');
var target_input_id = organization_autocomplete.attr('target-input-id');
var target_input = $('input#'+target_input_id);
Organization.getOptions().done(function (data) {
    Organization.map = {};
    var options = data.organizations.reduce(function (options, org, key) {
        Organization.map[org.name] = org.id;
        options[org.name] = null;
        return options;
    }, {});
    organization_autocomplete.autocomplete({
        data: options,
        limit: 10,
        onAutocomplete: function (name) {
            target_input.val(Organization.map[name]);
        },
        minLength: 2,
    });
});
```

Notice that this will work if, for example, a Job form requires an autocomplete of an organization. The hidden input might have properties, `id="organization-id" name="organization_id"`, but as long as the autocomplete has a matching `target-input-id` attribute, it will work.
