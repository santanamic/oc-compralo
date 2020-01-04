# Compralo payment modulo for OpenCart 3.x


To make Compralo available as a payment facilitator on the OpenCart platform, simply download the package and extract the module folder into your store configuration files.

Please note that your OpenCart installation version must be compatible with the Compralo module. The module was developed with support for the latest version of OpenCart 3.X.


#### 1- OpenCart Module Installation

To install the module it is necessary to download the package through the link: https://raw.github.com/santanamic/oc-compralo/master/compralo_opencart_v.3.x.zip

Unzip the downloaded file and copy the folder to the root directory of your OpenCart installation, if the system displays the message merge or replace files, click yes to all.

Steps for installing via FTP using Filezilla:

1. Send the contents of the extracted folder to the webshop server using FTP software (in this example we use Filezilla)

2. When connecting to FTP, on the right side will be shown the folders that are inside the server, go to the folder containing your opencart installation.

3. Send the extracted (**admin** and **catalog**) folders from the Compralo module to the opencart folder

Be careful not to drag a system folder; if this happens, you will have one folder in another and this module will not work.

![OpenCart, install](https://raw.github.com/santanamic/oc-compralo/master/docs/_media/1.png "OpenCart, install")

Following are the folders in the OpenCart installation directory:

![OpenCart, install](https://raw.github.com/santanamic/oc-compralo/master/docs/_media/2.png "OpenCart, install")

Once your Compralo module has been submitted, go to Opencart administration and find the "Payment Methods" section in the Extensions menu.

Search for the “Compralo” module

![OpenCart, install](https://raw.github.com/santanamic/oc-compralo/master/docs/_media/3.png "OpenCart, install")

The module will be shown as the image below. Click the **install** button to start the module installation.

![OpenCart, install](https://raw.github.com/santanamic/oc-compralo/master/docs/_media/4.png "OpenCart, install")

After installation, you will need to enable and enter authentication data to link your store with Compralo.

#### 2- OpenCart Module Configuration


On the **Payment Methods** page, click **Edit** to access the Compralo module. The module page will be loaded with the configuration options below:

![OpenCart, install](https://raw.github.com/santanamic/oc-compralo/master/docs/_media/5.png "OpenCart, install")


> Configuration Options:


**Payment Method Enabled:** Enable to use. Disable to turn off.

**API Public Key:** Compralo API Authentication Public Key.

**Payment Title:**  Choose the title displayed to customers during checkout.

**Confirm Button Text:** Button text for payment confirmation.

**Order Status:** Order status when an order is placed in the store.

**Paid Status:** Order status when a payment is confirmed by Compralo.

**Invalid Status:** Status when an order is unsuccessful.

**Sort Order:**  Payment method position on checkout page.