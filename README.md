# Magento-2-Extra-Form-PDF-Email
Magento 2 Extra Form with PDF generation &amp; send Email



install the module using the below commands.

#COPY CODE
Upload files to app/code

#Enable module 

php bin/magento module:enable Sharpeningservices_MailAttachment;

#Upgrade module 

php bin/magento setup:upgrade;


#Compile module 

php bin/magento setup:di:compile;


#Clear Cache

php bin/magento cache:clean;

php bin/magento cache:flush;


#Deploy static content


php bin/magento setup:static-content:deploy -f;

