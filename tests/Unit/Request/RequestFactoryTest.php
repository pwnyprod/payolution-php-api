<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Mocks\Request\Elv\PreCheckData as ElvPreCheckData;
use ArvPayolutionApi\Mocks\Request\Installment\PreCheckData as InstallmentPreCheckData;
use ArvPayolutionApi\Mocks\Request\Invoice\CaptureData as InvoiceCaptureData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreAuthData as InvoicePreAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckData as InvoicePreCheckData;
use ArvPayolutionApi\Mocks\Request\PreCheckDataContract;
use ArvPayolutionApi\Mocks\Request\PreCheckXmlMockFactory;
use ArvPayolutionApi\Request\RequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\XmlSerializer;
use ArvPayolutionApi\Request\XmlSerializerFactory;

/**
 * Class RequestFactoryTest
 */
class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlSerializer
     */
    protected $xmlSerializer;
    /** @var PreCheckDataContract $data */
    private $data;

    public function setUp()
    {
        $this->xmlSerializer = XmlSerializerFactory::create();
    }

    public function testInvoicePreCheckSameAsMock()
    {
        $this->data = new InvoicePreCheckData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
        ];

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml('Invoice', $requestType)->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    public function testElvPreCheckSameAsMock()
    {
        $this->data = new ElvPreCheckData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'account' => $this->data->getAccountData(),
        ];

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_ELV;

        self::assertSame(
            PreCheckXmlMockFactory::getRequestXml('Elv', $requestType)->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    public function testInstallmentPreCheckSameAsMock()
    {
        $this->data = new InstallmentPreCheckData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'account' => $this->data->getAccountData(),
            'installment' => $this->data->getInstallmentData(),
        ];

        $requestType = RequestTypes::PRE_CHECK; // for Pre-Check, Pre- & Re-Authorization,
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INS;

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml(
                'Installment',
                $requestType
            )->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    public function testInvoiceCaptureSameAsMock()
    {
        $this->data = new InvoiceCaptureData();
        $data = [
            'context' => $this->data->getApiContext(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'invoice' => $this->data->getInvoice(),
            'order' => $this->data->getOrder(),
            'tracking' => $this->data->getTracking(),
            'cart' => $this->data->getCart(),
            'customer' => $this->data->getCustomer(),
        ];

        $requestType = RequestTypes::CAPTURE; // for Pre-Check, Pre- & Re-Authorization,
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml(
                'Invoice',
                $requestType
            )->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId),
                ],
                true
            )
        );
    }

    public function testInvoicePreAuthSameAsMock()
    {
        $this->data = new InvoicePreAuthData();
        $data = [
            'context' => $this->data->getApiContext(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'customer' => $this->data->getCustomer(),
        ];

        $requestType = RequestTypes::PRE_AUTH; // for Pre-Check, Pre- & Re-Authorization,
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;
        $previousRequestId = '53488b162da3e294012db761fd734288';

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml(
                'Invoice',
                $requestType
            )->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId),
                ],
                true
            )
        );
    }
}
