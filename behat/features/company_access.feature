Feature: Company access
  In order to be keep the company info secure
  As a non privileged user
  We need to be denied access to private companies

  @api
  Scenario Outline: Validate anonymous user has no access to company
    Given I am an anonymous user
    When I visit <url>
    Then I should get a "403" HTTP response

    Examples:
    | url   |
    |       |
