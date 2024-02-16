<?php
    use PHPUnit\Framework\TestCase;
    use Facebook\WebDriver\Remote\DesiredCapabilities;
    use Facebook\WebDriver\Remote\RemoteWebDriver;
    use Facebook\WebDriver\WebDriverBy;

    class CartTest extends TestCase
    {
        protected $webDriver;

        protected function setUp(): void
        {
            $capabilities = DesiredCapabilities::chrome();
            $capabilities->setCapability('browserstack.user', 'stanislavmiroshn_Sx25MD');
            $capabilities->setCapability('browserstack.key', 'yZcSY2cEXQQttsAvg8hf');

            // Указываете на удаленный Selenium WebDriver, предоставляемый BrowserStack
            $host = 'http://hub-cloud.browserstack.com/wd/hub';

            $this->webDriver = RemoteWebDriver::create($host, $capabilities);
        }

        public function testAddToCart()
        {
            $this->webDriver->get('https://store.unesell.com/product/?id=omr7phdu20y4iec');

            // Находим кнопку "Добавить в корзину" и нажимаем на нее
            $addToCartButton = $this->webDriver->findElement(WebDriverBy::id('addcard'));
            $addToCartButton->click();

            // Проверяем, что товар был успешно добавлен в корзину
            $cartItem = $this->webDriver->findElement(WebDriverBy::id('omr7phdu20y4iec'));
            $this->assertTrue($cartItem->isDisplayed());
        }

        public function testDeleteFromCart()
        {
            $this->webDriver->get('https://store.unesell.com/product/?id=omr7phdu20y4iec');

            // Находим кнопку "Удалить из корзины" и нажимаем на нее
            $deleteFromCartButton = $this->webDriver->findElement(WebDriverBy::id('delcart'));
            $deleteFromCartButton->click();

            // Проверяем, что товар был успешно удален из корзины
            $cartItem = $this->webDriver->findElements(WebDriverBy::id('omr7phdu20y4iec'));
            $this->assertCount(0, $cartItem);
        }

        protected function tearDown(): void
        {
            $this->webDriver->quit();
        }
    }
?>
