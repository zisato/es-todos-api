Feature:
  In order to use EsTodosApi
  I want to list todos

  Background: Creates user, todo
    Given the following users exists:
    | id                                   | identification      | name      |
    | b4c867fe-f822-4639-865a-9f9ca3835a42 | User identification | User name |
    Given the following todos exists:
    | id                                   | user_id                              | title        | description        |
    | 3d900d32-8d47-11ea-bc55-0242ac130003 | b4c867fe-f822-4639-865a-9f9ca3835a42 | Todo title 1 | Todo description 1 |
    | 09eb1b50-1e9f-11ea-978f-2e728ce88125 | b4c867fe-f822-4639-865a-9f9ca3835a42 | Todo title 2 | Todo description 2 |

  Scenario: It list todos successfully
    When I call "GET" "/todos"
    Then the status code should be 200
    And the response should matches
    """
      {
        "data": [
          {
            "id":"3d900d32-8d47-11ea-bc55-0242ac130003",
            "attributes": {
              "title": "Todo title 1",
              "description": "Todo description 1"
            },
            "relationships": {
              "user": {
                "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
              }
            }
          },
          {
            "id":"09eb1b50-1e9f-11ea-978f-2e728ce88125",
            "attributes": {
              "title": "Todo title 2",
              "description": "Todo description 2"
            },
            "relationships": {
              "user": {
                "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
              }
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

  Scenario: It list todos with pagination successfully
    When I call "GET" "/todos?page=2&perPage=1"
    Then the status code should be 200
    And the response should matches
    """
      {
        "data": [
          {
            "id":"09eb1b50-1e9f-11ea-978f-2e728ce88125",
            "attributes": {
              "title": "Todo title 2",
              "description": "Todo description 2"
            },
            "relationships": {
              "user": {
                "id": "b4c867fe-f822-4639-865a-9f9ca3835a42"
              }
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