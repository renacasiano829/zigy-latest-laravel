![Ziggy - Use your Laravel Named Routes inside Javascript](http://i.imgur.com/JLC1ZP6.png)

![Ziggy Javascript Laravel Routes Example](http://i.imgur.com/tWu1ZqT.gif)

# Ziggy - Use your Laravel Named Routes inside Javascript

Ziggy creates a Blade directive which you can include in your views. This will export a JavaScript object of your application's named routes, keyed by their names (aliases), as well as a global `route()` helper function which you can use to access your routes in your JS.

## Installation 

1. Add Ziggy to your Composer file: `composer require tightenco/ziggy`

2. (if Laravel 5.4) Add `Tightenco\Ziggy\ZiggyServiceProvider::class` to the `providers` array in your `config/app.php`.

3. Include our Blade Directive (`@routes`) somewhere in your template before your main application JavaScript is loaded--likely in the header somewhere.

## Usage

This package replaces the `@routes` directive with a collection of all of your application's routes, keyed by their names. This collection is available at `window.namedRoutes`.

The package also creates an optional `route()` JavaScript helper which functions like Laravel's `route()` PHP helper, which can be usedc to retrieve URLs by name and (optionally) parameters. 

For example:

`route('posts.index')` should return `posts`

If you wish to retrieve the URL for a route with required parameters, pass a JavaScript object with the parameterss as the second argument to `route()`:

`route('posts.show', {id: 1})` should return `posts/1`

Here's a full example:

```javascript
let postId = 1337;

return axios.get(route('posts.show', {id: postId}))
    .then((response) => {
        return response.data;
    });
```

## Caching
Laravel caches views by default, so we're circumventing View caching by default when `config('app.env')` is `local`.
If you want to do this in some other environment for some reason, just set `ziggy_cache` to `false` in your `config/app.php`.

If you don't already, we'd recomment making sure you're running `view:clear` when deploying to non-local environments to make sure all your changes get reflected on the server.


## Credits

Author: [Daniel Coulbourne](https://twitter.com/DCoulbourne)

Thanks to [Caleb Porzio](http://twitter.com/calebporzio), [Adam Wathan](http://twitter.com/adamwathan), [Matt Stauffer](http://twitter.com/stauffermatt), and [Jeffrey Way](http://twitter.com/jeffrey_way).
