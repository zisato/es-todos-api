Feature:
  In order to use EsTodosApi
  I want to create todo

  Background: Creates user
    Given the following users exists:
    | id                                   | identification      | name      |
    | b4c867fe-f822-4639-865a-9f9ca3835a42 | User identification | User name |

  Scenario: It creates a todo with required parameters
    When I call "POST" "/todos" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "title": "Todo title",
            "description": "Todo description"
          },
          "relationships": {
            "user": {
              "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
            }
          }
        }
      }
    """
    Then the status code should be 201
    And the response should be empty
    When I call "GET" "/todos/0ae12040-4b00-11e9-b475-0800200c9a66"
    And the response should matches
    """
      {
        "data": {
          "id":"0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "title": "Todo title",
            "description": "Todo description"
          },
          "relationships": {
            "user": {
              "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
            }
          }
        }
      }
    """

  Scenario: It returns error on create with existing id
    When I call "POST" "/todos" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "title": "Todo title",
            "description": "Todo description"
          },
          "relationships": {
            "user": {
              "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
            }
          }
        }
      }
    """
    Then the status code should be 201
    Then I call "POST" "/todos" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "title": "Another Todo title",
            "description": "Another Todo description"
          },
          "relationships": {
            "user": {
              "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
            }
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

  Scenario: It returns error on create with not existing user id
    When I call "POST" "/todos" with body:
    """
      {
        "data": {
          "id": "0ae12040-4b00-11e9-b475-0800200c9a66",
          "attributes": {
            "title": "Todo title",
            "description": "Todo description"
          },
          "relationships": {
            "user": {
              "id": "ec8199d8-d4c6-44db-ad88-53e38cb9af73"
            }
          }
        }
      }
    """
    Then the status code should be 404
    And the response should be a JSON like
    """
      {
        "status": 404,
        "type": "about:blank",
        "title": "Not Found"
      }
    """