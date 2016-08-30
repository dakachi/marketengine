<?php
echo "<pre>";
print_r($_POST);
print_r($_REQUEST);
echo "</pre>";
?>
<html>
    <head>
        <title>Autosuggest Example 1</title>
        <script type="text/javascript" src="autosuggest1.js"></script>
        <script type="text/javascript" src="suggestions1.js"></script>
        <script type="text/javascript">
            window.onload = function () {
                var oTextbox = new AutoSuggestControl(document.getElementById("txt1"), new StateSuggestions()); 
            }
        </script>
    </head>
    <body>
        <p><input type="text" id="txt1" /></p>
    </body>
</html>
<?php
/*
Array
(
[mc_gross] => 4000.00
[protection_eligibility] => Eligible
[address_status] => confirmed
[item_number1] => 132
[payer_id] => UADMHTRMVRHTQ
[tax] => 0.00
[address_street] => 1 Main St
[payment_date] => 21:37:11 Aug 29, 2016 PDT
[payment_status] => Completed
[charset] => utf-8
[address_zip] => 95131
[mc_shipping] => 0.00
[mc_handling] => 0.00
[first_name] => ledd
[mc_fee] => 116.30
[address_country_code] => US
[address_name] => ledd dakac
[notify_version] => 3.8
[custom] => {\"order_id\":404}
[payer_status] => verified
[business] => dinhle1987-biz@yahoo.com
[address_country] => United States
[num_cart_items] => 1
[mc_handling1] => 0.00
[address_city] => San Jose
[payer_email] => dinhle1987-pers2@yahoo.com
[verify_sign] => AWfYvpOYY9QGK6LMTcBhquaTPxFyALShAu0huejjZ8Qh9IUoK6mfw26.
[mc_shipping1] => 0.00
[tax1] => 0.00
[txn_id] => 6B91747228835915A
[payment_type] => instant
[last_name] => dakac
[item_name1] => Selling Listing 1
[address_state] => CA
[receiver_email] => dinhle1987-biz@yahoo.com
[payment_fee] => 116.30
[quantity1] => 2
[receiver_id] => PTRV3WCVA7PP2
[txn_type] => cart
[mc_gross_1] => 4000.00
[mc_currency] => USD
[residence_country] => US
[test_ipn] => 1
[transaction_subject] =>
[payment_gross] => 4000.00
[auth] => AO8EvUSOmjOHrgZrpV9DYI2drRBTM.ak4dwt9yFB1ppVM7rWgCqxhv0M6i0Q4ih6K8LgkMrmpFRCtiAArGftI1A
)
 */