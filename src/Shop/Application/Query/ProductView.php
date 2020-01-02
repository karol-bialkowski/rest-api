<?php

declare(strict_types=1);

namespace App\Shop\Application\Query;


use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

class ProductView implements ProductQuery
{

    /**
     * @var string
     */
    private string $uuid;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $price;
    /**
     * @var NumberFormatter
     */
    private NumberFormatter $formatter;
    /**
     * @var ISOCurrencies
     */
    private ISOCurrencies $currencies;
    /**
     * @var NumberFormatter
     */
    private NumberFormatter $numberFormatter;
    /**
     * @var IntlMoneyFormatter
     */
    private IntlMoneyFormatter $moneyFormatter;

    public function __construct(string $uuid, string $title, string $price)
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->price = $price;
        $this->currencies = new ISOCurrencies();
        $this->numberFormatter = new \NumberFormatter('en', \NumberFormatter::CURRENCY);
        $this->moneyFormatter = new IntlMoneyFormatter($this->numberFormatter, $this->currencies);


    }

    public function isUniqueTitle(string $title)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getByTitle(string $title)
    {
        // TODO: Implement getByTitle() method.
        // TODO verify all methods, Interface Segragtion principe!
    }

    /**
     * @return array
     */
    public function toArrayResponse()
    {
        $price = new Money($this->getPrice(), new Currency('USD'));
        return [
            'uuid' => $this->getUuid(),
            'title' => $this->getTitle(),
            'price' => [
                'cents' => $this->getPrice(),
                'format' =>
                    [
                        'usd' => $this->moneyFormatter->format($price)
                    ]
            ]
        ];
    }
}
