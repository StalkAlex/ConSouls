Feature: Sum calculating end-point

  Scenario: Check that end-point returning sum of two variables is correct
    When I am on "/sum/3/4"
    Then the response status code should be 200
    And Sum should be equals 7
