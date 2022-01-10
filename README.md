# Magento2 Module Delgraf RegionCode

    ``delgraf/module-regioncode``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)


## Main Functionalities
 - Enable region code in customer address templates using {{var region_id}}
 - Add region code in store address

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Composer

 - Go to Magento2 root folder
 - Install the module composer by running `composer require delgraf/module-regioncode`
 - Enable the module by running `php bin/magento module:enable Delgraf_RegionCode`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Zip file

 - Unzip the zip file in `app/code/Delgraf`
 - Enable the module by running `php bin/magento module:enable Delgraf_RegionCode`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`
