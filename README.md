![Hungersoft.com](https://www.hungersoft.com/skin/front/custom/images/logo.png)

# Facebook Comments [M2]
**hs/module-facebook-comments**

Hungersoft's [Facebook Comments](https://www.hungersoft.com/p/magento2-product-facebook-commentser) extension allows you to show Facebook comment box on your product page.

## Installation

```sh
composer config repositories.hs-module-all vcs https://github.com/hungersoft/module-all.git
composer config repositories.hs-module-facebook-comments vcs https://github.com/hungersoft/magento2-facebook-comments.git
composer require hs/module-facebook-comments:dev-master

php bin/magento module:enable HS_All HS_ImageClean
php bin/magento setup:upgrade
```

**Note:** Make sure you've installed our Base extension. The above commands already include it, but if you haven't, you can find it [here](https://github.com/hungersoft/module-all)

## Support

Magento 2 Facebook Comments extension is provided for free by Hungersoft. Feel free to contact Hungersoft at support@hungersoft.com if you are facing any issues with this extension. Reviews, suggestions and feedback will be greatly appreciated.
