Feature: Company access
  In order to be keep the company info secure
  As a non privileged user
  We need to be denied access to private companies

  @api @foo
  Scenario Outline: Validate anonymous user has no access to company
    Given I am an anonymous user
    When I goto "<url>"
    Then I should get access denied

    Examples:
    | url           |
    | node/1        |
    | node/1/edit   |
    | node/1/delete |
