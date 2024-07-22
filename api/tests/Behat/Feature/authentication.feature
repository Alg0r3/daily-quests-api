Feature: JWT Authentication

  Scenario: Successful user authentication
    Given a user with valid credentials
    When the user attempts to authenticate to the API
    Then the response HTTP status code should be 200
    And a JWT Token should be successfully returned to the user

  Scenario: Failed user authentication
    Given a user with invalid credentials
    When the user attempts to authenticate to the API
    Then the response HTTP status code should be 401
