<?php

use Drupal\DrupalExtension\Context\DrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

class ApiContext extends DrupalContext implements SnippetAcceptingContext {

  /**
   * The base URL for the scenario.
   *
   * @var string
   */
  protected $baseUrl;

  public function __construct($parameters) {
    $this->baseUrl = $parameters['base_url'];
  }

  /**
   * @BeforeScenario
   *
   * Set the base URL per suite.
   */
  public function setBaseUrl(BeforeScenarioScope $scope) {
    $environment = $scope->getEnvironment();

    foreach ($environment->getContexts() as $context) {
      if ($context instanceof \Behat\MinkExtension\Context\RawMinkContext) {
        $context->setMinkParameter('base_url', $this->baseUrl);
      }
    }
  }

  /**
   * @When /^I login with user "([^"]*)"$/
   */
  public function iLoginWithUser($name) {
    // $password = $this->drupal_users[$name];
    $password = 'admin';
    $this->loginUser($name, $password);
  }

  /**
   * Login a user to the site.
   *
   * @param $name
   *   The user name.
   * @param $password
   *   The use password.
   *
   * @throws \Exception
   */
  protected function loginUser($name, $password) {
    $this->getSession()->visit($this->locatePath('/user'));
    $element = $this->getSession()->getPage();
    $element->fillField('username', $name);
    $element->fillField('password', $password);
    $submit = $element->findButton('Log in');

    if (empty($submit)) {
      throw new \Exception(sprintf("No submit button at %s", $this->getSession()->getCurrentUrl()));
    }

    // Log in.
    $submit->click();
  }

  /**
   * @When I goto :path
   *
   * Similar to "I visit :path", only without the response code assertion.
   */
  public function iGoto($path) {
    $this->getSession()->visit($this->locatePath($path));
  }

  /**
   * @Then I should get access denied
   */
  public function iShouldGetAccessDenied() {
    $this->assertSession()->statusCodeEquals(403);
  }
}
