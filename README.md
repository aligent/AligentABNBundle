Aligent ABN Bundle for OroCommerce
==============================================

Facts
-----
- version: 4.0.0 (Compatible with OroCommerce >=4.0)
- composer name: aligent/orocommerce-abn-bundle

Description
-----------
The Aligent ABN bundle adds the abn field to the customer entity and the customer registration form. It allows the users
to be assigned to groups depending on whether they enter an ABN or not and allows for the field to be marked as required
so they must sign up with it.

Installation Instructions
-------------------------
1. Install this module via Composer

        composer require aligent/orocommerce-abn-bundle

1. Clear cache and run migrations
        
        php app/console cache:clear --env=prod
        php app/console oro:migration:load --force --env=prod
        
1. To Enable and Configure the module head to:
    System > Configuration > Aligent > ABN

Developers
---------
Jim O'Halloran <jim@aligent.com.au>
Adam Hall <adam.hall@aligent.com.au>

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2017 Aligent Consulting
