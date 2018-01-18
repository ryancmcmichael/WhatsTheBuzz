<?php
/**
 * Braintree base class and initialization
 *
 *  PHP version 5
 *
 * @copyright  2010 Braintree Payment Solutions
 */


set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__)));

/**
 * Braintree PHP Library
 *
 * Provides methods to child classes. This class cannot be instantiated.
 *
 * @copyright  2010 Braintree Payment Solutions
 */
abstract class Braintree
{
    /**
     * @ignore
     * don't permit an explicit call of the constructor!
     * (like $t = new Braintree_Transaction())
     */
    protected function __construct()
    {
    }
    /**
     * @ignore
     *  don't permit cloning the instances (like $x = clone $v)
     */
    protected function __clone()
    {
    }

    /**
     * returns private/nonexistent instance properties
     * @ignore
     * @access public
     * @param string $name property name
     * @return mixed contents of instance properties
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        }
        else {
            trigger_error('Undefined property on ' . get_class($this) . ': ' . $name, E_USER_NOTICE);
            return null;
        }
    }

    /**
     * used by isset() and empty()
     * @access public
     * @param string $name property name
     * @return boolean
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->_attributes);
    }

    public function _set($key, $value)
    {
        $this->_attributes[$key] = $value;
    }

    /**
     *
     * @param string $className
     * @param object $resultObj
     * @return object returns the passed object if successful
     * @throws Braintree_Exception_ValidationsFailed
     */
    public static function returnObjectOrThrowException($className, $resultObj)
    {
        $resultObjName = Braintree_Util::cleanClassName($className);
        if ($resultObj->success) {
            return $resultObj->$resultObjName;
        } else {
            throw new Braintree_Exception_ValidationsFailed();
        }
    }
}
require_once('braintree/Modification.php');
require_once('braintree/Instance.php');

require_once('braintree/Address.php');
require_once('braintree/AddOn.php');
require_once('braintree/Collection.php');
require_once('braintree/Configuration.php');
require_once('braintree/CreditCard.php');
require_once('braintree/Customer.php');
require_once('braintree/CustomerSearch.php');
require_once('braintree/DisbursementDetails.php');
require_once('braintree/Descriptor.php');
require_once('braintree/Digest.php');
require_once('braintree/Discount.php');
require_once('braintree/IsNode.php');
require_once('braintree/EqualityNode.php');
require_once('braintree/Exception.php');
require_once('braintree/Http.php');
require_once('braintree/KeyValueNode.php');
require_once('braintree/MerchantAccount.php');
require_once('braintree/MerchantAccount/BusinessDetails.php');
require_once('braintree/MerchantAccount/FundingDetails.php');
require_once('braintree/MerchantAccount/IndividualDetails.php');
require_once('braintree/MerchantAccount/AddressDetails.php');
require_once('braintree/MultipleValueNode.php');
require_once('braintree/MultipleValueOrTextNode.php');
require_once('braintree/PartialMatchNode.php');
require_once('braintree/Plan.php');
require_once('braintree/RangeNode.php');
require_once('braintree/ResourceCollection.php');
require_once('braintree/SettlementBatchSummary.php');
require_once('braintree/Subscription.php');
require_once('braintree/SubscriptionSearch.php');
require_once('braintree/TextNode.php');
require_once('braintree/Transaction.php');
require_once('braintree/TransactionSearch.php');
require_once('braintree/TransparentRedirect.php');
require_once('braintree/Util.php');
require_once('braintree/Version.php');
require_once('braintree/Xml.php');
require_once('braintree/Error/Codes.php');
require_once('braintree/Error/ErrorCollection.php');
require_once('braintree/Error/Validation.php');
require_once('braintree/Error/ValidationErrorCollection.php');
require_once('braintree/Exception/Authentication.php');
require_once('braintree/Exception/Authorization.php');
require_once('braintree/Exception/Configuration.php');
require_once('braintree/Exception/DownForMaintenance.php');
require_once('braintree/Exception/ForgedQueryString.php');
require_once('braintree/Exception/InvalidSignature.php');
require_once('braintree/Exception/NotFound.php');
require_once('braintree/Exception/ServerError.php');
require_once('braintree/Exception/SSLCertificate.php');
require_once('braintree/Exception/SSLCaFileNotFound.php');
require_once('braintree/Exception/Unexpected.php');
require_once('braintree/Exception/UpgradeRequired.php');
require_once('braintree/Exception/ValidationsFailed.php');
require_once('braintree/Result/CreditCardVerification.php');
require_once('braintree/Result/Error.php');
require_once('braintree/Result/Successful.php');
require_once('braintree/Test/CreditCardNumbers.php');
require_once('braintree/Test/MerchantAccount.php');
require_once('braintree/Test/TransactionAmounts.php');
require_once('braintree/Test/VenmoSdk.php');
require_once('braintree/Transaction/AddressDetails.php');
require_once('braintree/Transaction/CreditCardDetails.php');
require_once('braintree/Transaction/CustomerDetails.php');
require_once('braintree/Transaction/StatusDetails.php');
require_once('braintree/Transaction/SubscriptionDetails.php');
require_once('braintree/WebhookNotification.php');
require_once('braintree/WebhookTesting.php');
require_once('braintree/Xml/Generator.php');
require_once('braintree/Xml/Parser.php');
require_once('braintree/CreditCardVerification.php');
require_once('braintree/CreditCardVerificationSearch.php');
require_once('braintree/PartnerMerchant.php');

if (version_compare(PHP_VERSION, '5.2.1', '<')) {
    throw new Braintree_Exception('PHP version >= 5.2.1 required');
}


function requireDependencies() {
    $requiredExtensions = array('xmlwriter', 'SimpleXML', 'openssl', 'dom', 'hash', 'curl');
    foreach ($requiredExtensions AS $ext) {
        if (!extension_loaded($ext)) {
            throw new Braintree_Exception('The Braintree library requires the ' . $ext . ' extension.');
        }
    }
}

requireDependencies();
