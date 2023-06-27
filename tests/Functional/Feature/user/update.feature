Feature:
  In order to use EsTodosApi
  I want to update user

  Background: Creates user
    Given the following users exists:
    | id                                   | identification      | name      |
    | 3d900d32-8d47-11ea-bc55-0242ac130003 | User identification | User name |

  Scenario: It updates a user
    When I call "PUT" "/users/3d900d32-8d47-11ea-bc55-0242ac130003" with body:
    """
      {
        "data": {
          "attributes": {
            "name": "New User name"
          }
        }
      }
    """
    Then the status code should be 204
    When I call "GET" "/users/3d900d32-8d47-11ea-bc55-0242ac130003"
    And the response should matches
    """
      {
        "data": {
          "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
          "attributes": {
            "identification": "User identification",
            "name": "New User name"
          }
        }
      }
    """

  @debug
  Scenario: It returns error when not exists
    When I call "PUT" "/users/0e122660-0b22-11ee-be56-0242ac120002" with body:
    """
      {
        "data": {
          "attributes": {
            "name": "New User name"
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
