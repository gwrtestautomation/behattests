<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Behat\Testwork\Hook\Scope\AfterSuiteScope;
/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{
     /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have a web browser
     */
    public function iHaveAWebBrowser()
    {
        $session = $this->getSession();
        $session->visit('https://www.greatwolf.com');
    }

    /**
     * @Given |I visit :arg1
     */
    public function iVisit($arg1)
    {
        $url = TestDataContext::getTestData($arg1);
        $this->getSession()->visit($url);
    }

    /**
     * @When |I click :arg1
     */
    public function iClick($arg1)
    {
        $arg1 = ElementLocatorsContext::getElementLocator($arg1);
        $page = $this->getSession()->getPage();
        $ele = $page->find('css', $arg1);
        $ele->click();
    }

    /**
     * @Then |I should see :arg
     */
    public function iShouldSee($arg)
    {
        $arg = ElementLocatorsContext::getElementLocator($arg);
        $this->getSession()->wait(4000);
        $this->assertSession()->elementExists('xpath', $arg);
    }

    /**
     * @Then |I should :arg
     */
    public function iShould($arg)
    {
        $arg = ElementLocatorsContext::getElementLocator($arg);
        $this->getSession()->wait(8000);
        $this->assertSession()->elementExists('xpath', $arg);
    }

    /**
     * @When |I fill in :arg1 with :arg2
     * @And |I fill in :arg1 with :arg2
     */
    public function iFillInWith($field, $text)
    {
        $field = ElementLocatorsContext::getElementLocator($field);
        $page = $this->getSession()->getPage();
        $ele = $page->find('xpath', $field);
        $ele->setValue($text);
    }

    /**
     * @When |I check :arg
     */
    public function iCheck($arg)
    {
        $field = ElementLocatorsContext::getElementLocator($arg);
        $page = $this->getSession()->getPage();
        $ele = $page->find('xpath', $field);
        $ele->check();
    }

    /**
     * @When |I fill in :arg1 with dynamic :arg2
     */
    public function iFillInWithDynamic($field, $text)
    {
        $field = ElementLocatorsContext::getElementLocator($field);
        $text = TestDataContext::getTestData($text);
        $page = $this->getSession()->getPage();
        $ele = $page->find('xpath', $field);
        $ele->setValue($text);
    }

    /**
     * @Then |I should receive a Welcome Email from Great Wolf Lodge
     **/
    public function verifyWelcomeEmail()
    {
        $emailVer = EmailVerificationAdapter::verifyEmail();
        assert(($emailVer[0] == 'true'), 'GWR Welcome email not received after - ' . $emailVer[1] . ' Secs.');
    }

    /**
     * @When |I am on the :arg1
     */
    public function iAmOnThe($arg1)
    {
        $arg1 = ElementLocatorsContext::getElementLocator($arg1);
        $this->getSession()->wait(4000);
        $this->assertSession()->elementExists('xpath', $arg1);
    }


    /**
     * @AfterSuite
     */
    public static function afterSuite(AfterSuiteScope $scope)
    {
       // UtilityContext::zipResults();
        SendEmailContext::sendEmailWithAttachment();
    }

}