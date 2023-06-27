Feature:
  In order to use EsTodosApi
  I want to list users

  Background: Creates user
    Given the following users exists:
    | id                                   | identification        | name        |
    | 3d900d32-8d47-11ea-bc55-0242ac130003 | User identification 1 | User name 1 |
    | 09eb1b50-1e9f-11ea-978f-2e728ce88125 | User identification 2 | User name 2 |

  Scenario: It list users successfully
    When I call "GET" "/users"
    Then the status code should be 200
    And the response should matches
    """
      {
        "data": [
          {
            "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
            "attributes": {
              "identification": "User identification 1",
              "name": "User name 1"
            }
          },
          {
            "id":"09eb1b50-1e9f-11ea-978f-2e728ce88125",
            "attributes": {
              "identification": "User identification 2",
              "name": "User name 2"
            }
          }
        ],
        "meta": {
          "pagination": {
            "total": 2,
            "page": 1,
            "per_page": 20,
            "total_pages": 1
          }
        }
      }
    """

  Scenario: It list users with pagination successfully
    When I call "GET" "/users?page=2&perPage=1"
    Then the status code should be 200
    And the response should matches
    """
      {
        "data": [
          {
            "id":"09eb1b50-1e9f-11ea-978f-2e728ce88125",
            "attributes": {
              "identification": "User identification 2",
              "name": "User name 2"
            }
          }
        ],
        "meta": {
          "pagination": {
            "total": 2,
            "page": 2,
            "per_page": 1,
            "total_pages": 2
          }
        }
      }
    """