<?php

namespace App\Services\PaymentGateways;

use InvalidArgumentException;

class PaymentGatewayManager
{
    /**
     * @var array<string, PaymentGatewayInterface>
     */
    protected array $gateways = [];

    public function __construct()
    {
        $this->register(new CashOnDeliveryGateway());
        $this->register(new BankTransferGateway());
        $this->register(new WalletTransferGateway());
        $this->register(new JazzCashHostedGateway());
        $this->register(new EasyPaisaHostedGateway());
        $this->register(new SafepayGateway());
    }

    public function register(PaymentGatewayInterface $gateway): self
    {
        $this->gateways[$gateway->getKey()] = $gateway;
        return $this;
    }

    public function get(string $key): PaymentGatewayInterface
    {
        if (!isset($this->gateways[$key])) {
            throw new InvalidArgumentException("Payment gateway [{$key}] is not registered.");
        }
        return $this->gateways[$key];
    }

    /**
     * @return PaymentGatewayInterface[]
     */
    public function getAvailableGateways(): array
    {
        return array_filter($this->gateways, fn(PaymentGatewayInterface $g) => $g->isEnabled());
    }

    public function has(string $key): bool
    {
        return isset($this->gateways[$key]);
    }
}
