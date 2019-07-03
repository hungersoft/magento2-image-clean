![Hungersoft.com](https://www.hungersoft.com/skin/front/custom/images/logo.png)

# Product Image Cleaner [M2]
**hs/module-image-clean**

Deleting a product in Magento does not delete the images it stores on the server. These images will probably stay there forever clogging up your disk space.

Hungersoft's [Product Image Cleaner](https://www.hungersoft.com/p/magento2-product-image-cleaner) extension allows you to delete these unused product images easily from your Magento admin.

## Installation

```sh
composer config repositories.hs-module-all vcs https://github.com/hungersoft/module-all.git
composer config repositories.hs-module-image-clean vcs https://github.com/hungersoft/module-image-clean.git
composer require hs/module-image-clean

php bin/magento module:enable HS_ImageClean
php bin/magento setup:upgrade
```

## Support

Magento 2 Product Image Cleaner extension is provided for free by Hungersoft. Feel free to contact Hungersoft at support@hungersoft.com if you are facing any issues with this extension. Reviews, suggestions and feedback will be greatly appreciated.
