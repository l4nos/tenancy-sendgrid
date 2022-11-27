<h1 align=center>
	Tenancy Sendgrid Senders
</h1>

 ## Intro

This package is designed to add api routes into your application to allow you to add Email / Domain authentication for your tenants with sendgrid.

## Setup

Install with: 
```
composer require lanos/laravel-sendgrid-tenancy
```
Then run migrations

```
php artisan migrate
```

A table called email_authentication should be created.

After that add the concern into the Tenant model.

```
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use SendsEmail;
    ...
}
```

This will add the required relationships and functions to the tenant() / Tenant:: interface.

Lastly, add the routes wherever suits your application by calling the static method:

```
SgTen::routes();
```

We do not automatically load the routes as we recognise that every tenancy application uses different routing and middleware options, and rather than making you configure your service provider we simply allow you to drop the routes where is most convenient, you can surround these routes with whatever prefix and middleware you desire.

## License

Please refer to [LICENSE.md](https://github.com/Lanos/tenancy-sendgrid/blob/main/LICENSE) for this project's license.
