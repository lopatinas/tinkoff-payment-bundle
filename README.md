# tinkoff-payment-bundle

## Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Lopatinas\TinkoffPaymentBundle\TinkoffPaymentBundle(),
            // ...
        ];
    }
}
```

## Set configuration

```yaml
# app/config/config.yml
tinkoff_payment:
    terminal_key: YourTerminalKey
    secret_key: YourSecretKey
    api_url: ApiUrl # default: https://securepay.tinkoff.ru/rest/
```