Feature:
  In order to use EsTodosApi
  I want to delete todo

  Background: Creates user, todo
    Given the following users exists:
    | id                                   | identification      | name      |
    | b4c867fe-f822-4639-865a-9f9ca3835a42 | User identification | User name |
    Given the following todos exists:
    | id                                   | user_id                              |  title     | description      |
    | 3d900d32-8d47-11ea-bc55-0242ac130003 | b4c867fe-f822-4639-865a-9f9ca3835a42 | Todo title | Todo description |

  Scenario: It deletes successfully
    When I call "DELETE" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003"
    Then the status code should be 204
    And I call "GET" "/todos/3d900d32-8d47-11ea-bc55-0242ac130003"
    Then the status code should be 404
