Feature:
  In order to use EsTodosApi
  I want to update todo

  Background: Creates user, todo
    Given the following users exists:
    | id                                   | identification      | name      |
    | b4c867fe-f822-4639-865a-9f9ca3835a42 | User identification | User name |
    Given the following todos exists:
    | id                                   | user_id                              | title      | description      |
    | 3d900d32-8d47-11ea-bc55-0242ac130003 | b4c867fe-f822-4639-865a-9f9ca3835a42 | Todo title | Todo description |

  Scenario: It updates a todo
    When I call "PUT" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003" with body:
    """
      {
        "data": {
          "attributes": {
            "title": "New Todo title",
            "description": "New Todo description"
          }
        }
      }
    """
    Then the status code should be 204
    When I call "GET" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003"
    And the response should matches
    """
      {
        "data": {
          "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
          "attributes": {
            "title": "New Todo title",
            "description": "New Todo description"
          },
          "relationships": {
            "user": {
              "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
            }
          }
        }
      }
    """

  Scenario: It updates a todo title
    When I call "PUT" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003" with body:
    """
      {
        "data": {
          "attributes": {
            "title": "New Todo title",
            "description": "Todo description"
          }
        }
      }
    """
    Then the status code should be 204
    When I call "GET" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003"
    And the response should matches
    """
      {
        "data": {
          "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
          "attributes": {
            "title": "New Todo title",
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

  Scenario: It updates a todo description
    When I call "PUT" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003" with body:
    """
      {
        "data": {
          "attributes": {
            "title": "Todo title",
            "description": "New Todo description"
          }
        }
      }
    """
    Then the status code should be 204
    When I call "GET" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003"
    And the response should matches
    """
      {
        "data": {
          "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
          "attributes": {
            "title": "Todo title",
            "description": "New Todo description"
          },
          "relationships": {
            "user": {
              "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
            }
          }
        }
      }
    """

  Scenario: It updates a todo description to null
    When I call "PUT" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003" with body:
    """
      {
        "data": {
          "attributes": {
            "title": "Todo title",
            "description": null
          }
        }
      }
    """
    Then the status code should be 204
    When I call "GET" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003"
    And the response should matches
    """
      {
        "data": {
          "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
          "attributes": {
            "title": "Todo title",
            "description": null
          },
          "relationships": {
            "user": {
              "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
            }
          }
        }
      }
    """

  Scenario: It returns error when not exists
    When I call "PUT" "/todos/0e122660-0b22-11ee-be56-0242ac120002" with body:
    """
      {
        "data": {
          "attributes": {
            "title": "New Todo title",
            "description": "New Todo description"
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
