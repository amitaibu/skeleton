Feature: General functionality, links and access

  @api
  Scenario Outline: Validate generic links are disabled
    Given I am an anonymous user
    When I goto "<url>"
    Then I should get a "404" HTTP response

    Examples:
    | url       |
    | node      |
    | rss.xml   |


  @api
  Scenario: Validate XML sitemap exists links are disabled
    Given I am an anonymous user
    When I goto "sitemap.xml"
    Then I should get a "200" HTTP response


  @api
  Scenario: Validate Google Analytics is enabled
    Given I am an anonymous user
    When  I am at "/"
    Then  I should see the text "(function(i,s,o,g,r,a,m)"
    And   I should see the text "GoogleAnalyticsObject"

