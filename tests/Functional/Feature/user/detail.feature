Feature:
  In order to use EsTodosApi
  I want to get detail user

  Background: Creates user
    Given the following users exists:
    | id                                   | identification      | name      |
    | 3d900d32-8d47-11ea-bc55-0242ac130003 | User identification | User name |

  Scenario: It show user successfully
    When I call "GET" "/users/3d900d32-8d47-11ea-bc55-0242ac130003"
    Then the status code should be 200
    And the response should matches
    """
      {
        "data": {
          "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
          "attributes": {
            "identification": "User identification",
            "name": "User name"
          }
        }
      }
    """
