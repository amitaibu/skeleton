Feature: General links and access

  @api @foo
  Scenario Outline: Validate anonymous user has no access to company
    Given I am an anonymous user
    When I goto "<url>"
    Then I should get a "404" HTTP response

    Examples:
    | url           |
    | node        |
    | rss.xml   |
