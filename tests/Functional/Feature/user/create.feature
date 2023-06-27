Feature:
  In order to use EsTodosApi
  I want to create user

  Scenario: It creates a user with required parameters
    When I call "POST" "/users" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "identification": "User identification",
            "name": "User name"
          }
        }
      }
    """
    Then the status code should be 201
    And the response should be empty
    When I call "GET" "/users/0ae12040-4b00-11e9-b475-0800200c9a66"
    And the response should matches
    """
      {
        "data": {
          "id":"0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "identification": "User identification",
            "name": "User name"
          }
        }
      }
    """

  Scenario: It returns error on create with existing id
    When I call "POST" "/users" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "identification": "User identification",
            "name": "User name"
          }
        }
      }
    """
    Then the status code should be 201
    Then I call "POST" "/users" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "identification": "Another User identification",
            "name": "Another User name"
          }
        }
      }
    """
    Then the status code should be 400
    And the response should be a JSON like
    """
      {
        "status": 400,
        "type": "about:blank",
        "title": "Bad Request"
      }
    """

  Scenario: It returns error on create with existing identification
    When I call "POST" "/users" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "identification": "user identification",
            "name": "User name"
          }
        }
      }
    """
    Then the status code should be 201
    Then I call "POST" "/users" with body:
    """
      {
        "data": {
          "id": "0238c978-1362-11ee-be56-0242ac120002",
          "attributes": {
            "identification": "User identification",
            "name": "Another User name"
          }
        }
      }
    """
    Then the status code should be 400
    And the response should be a JSON like
    """
      {
        "status": 400,
        "type": "about:blank",
        "title": "Bad Request"
      }
    """
