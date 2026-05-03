## API Documentation

This API is built with Laravel and uses Sanctum for authentication.

### Base URL
`https://backend-main-iytocs.laravel.cloud/api`

### Authentication
Most endpoints require authentication using Laravel Sanctum. Include the Bearer token in the Authorization header: `Authorization: Bearer {token}`.

### Endpoints

#### Authentication Endpoints

- **POST /register**
  - Description: Register a new user
  - Body: JSON object with user registration details
    ```json
    {
      "username": "string (required)",
      "email": "string (required, unique)",
      "password": "string (required, min 6 characters)",
      "customer": {
        "name": "string (optional)",
        "address": "string (optional)",
        "phone_number": "string (optional)",
        "gender": "string (optional)"
      }
    }
    ```
  - Response: JSON with user data and access token
    ```json
    {
      "access_token": "string",
      "token_type": "Bearer",
      "user_id": 1,
      "role": ["customer"]
    }
    ```
  - Status Codes: 201 (Created), 422 (Validation Error)

- **POST /login**
  - Description: Authenticate user and get access token
  - Body: JSON object with credentials
    ```json
    {
      "email": "string (required)",
      "password": "string (required)"
    }
    ```
  - Response: JSON with user data and access token
    ```json
    {
      "access_token": "string",
      "token_type": "Bearer",
      "user_id": 1,
      "role": ["customer"]
    }
    ```
  - Status Codes: 200 (OK), 401 (Unauthorized)

#### Protected Endpoints (Require Authentication)

- **POST /logout**
  - Description: Logout the authenticated user (invalidate token)
  - Headers: `Authorization: Bearer {token}`
  - Response: JSON confirmation
    ```json
    {
      "message": "Logged out successfully"
    }
    ```
  - Status Codes: 200 (OK)

- **GET /profile**
  - Description: Get the authenticated user's profile
  - Headers: `Authorization: Bearer {token}`
  - Response: JSON with user profile data
    ```json
    {
      "message": "Profile retrieved successfully",
      "user": {
        "id": 1,
        "username": "johndoe",
        "email": "john@example.com",
        "email_verified_at": null,
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T10:00:00.000000Z",
        "customer": {
          "id": 1,
          "name": "John Doe",
          "address": "123 Main St",
          "phone_number": "1234567890",
          "gender": "male"
        }
      }
    }
    ```
  - Status Codes: 200 (OK)

- **PUT /edit-profile**
  - Description: Update the authenticated user's profile
  - Headers: `Authorization: Bearer {token}`
  - Body: JSON object with fields to update (all fields optional)
    ```json
    {
      "username": "string (optional)",
      "email": "string (optional, unique)",
      "password": "string (optional, min 6 characters)",
      "customer": {
        "name": "string (optional)",
        "address": "string (optional)",
        "phone_number": "string (optional)",
        "gender": "string (optional)"
      }
    }
    ```
  - Response: JSON with updated user data
    ```json
    {
      "message": "Profile updated successfully",
      "user": {
        "id": 1,
        "username": "johndoe_updated",
        "email": "john_updated@example.com",
        "email_verified_at": null,
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T10:00:00.000000Z",
        "customer": {
          "id": 1,
          "name": "John Doe Updated",
          "address": "456 New St",
          "phone_number": "0987654321",
          "gender": "male"
        }
      }
    }
    ```
  - Status Codes: 200 (OK), 422 (Validation Error)

- **PATCH /edit-profile**
  - Description: Partially update the authenticated user's profile (same as PUT)
  - Headers: `Authorization: Bearer {token}`
  - Body: JSON object with fields to update (all fields optional)
    ```json
    {
      "username": "string (optional)",
      "email": "string (optional, unique)",
      "password": "string (optional, min 6 characters)",
      "customer": {
        "name": "string (optional)",
        "address": "string (optional)",
        "phone_number": "string (optional)",
        "gender": "string (optional)"
      }
    }
    ```
  - Response: JSON with updated user data
    ```json
    {
      "message": "Profile updated successfully",
      "user": {
        "id": 1,
        "username": "johndoe_updated",
        "email": "john_updated@example.com",
        "email_verified_at": null,
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T10:00:00.000000Z",
        "customer": {
          "id": 1,
          "name": "John Doe Updated",
          "address": "456 New St",
          "phone_number": "0987654321",
          "gender": "male"
        }
      }
    }
    ```
  - Status Codes: 200 (OK), 422 (Validation Error)

#### Pets Resource (CRUD Operations)

- **GET /pets**
  - Description: List all pets belonging to the authenticated user
  - Headers: `Authorization: Bearer {token}`
  - Response: JSON array of pets
    ```json
    {
      "success": true,
      "message": "Pets retrieved successfully",
      "data": [
        {
          "id": 1,
          "customer_id": 1,
          "name": "Buddy",
          "species": "Dog",
          "age": "2 years",
          "color": "Brown",
          "gender": "male",
          "created_at": "2026-05-03T10:00:00.000000Z",
          "updated_at": "2026-05-03T10:00:00.000000Z",
          "customer": {
            "id": 1,
            "name": "John Doe",
            "address": "123 Main St",
            "phone_number": "1234567890",
            "gender": "male"
          }
        }
      ]
    }
    ```
  - Status Codes: 200 (OK)

- **POST /pets**
  - Description: Create a new pet for the authenticated user
  - Headers: `Authorization: Bearer {token}`
  - Body: JSON object with pet details
    ```json
    {
      "name": "string (required)",
      "species": "string (required)",
      "age": "string (required)",
      "color": "string (required)",
      "gender": "string (required, enum: male, female)"
    }
    ```
  - Response: JSON with created pet data
    ```json
    {
      "success": true,
      "message": "Pet created successfully",
      "data": {
        "id": 1,
        "customer_id": 1,
        "name": "Buddy",
        "species": "Dog",
        "age": "2 years",
        "color": "Brown",
        "gender": "male",
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T10:00:00.000000Z"
      }
    }
    ```
  - Status Codes: 201 (Created), 422 (Validation Error)

- **GET /pets/{id}**
  - Description: Get details of a specific pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Response: JSON with pet data
    ```json
    {
      "success": true,
      "message": "Pet retrieved successfully",
      "data": {
        "id": 1,
        "customer_id": 1,
        "name": "Buddy",
        "species": "Dog",
        "age": "2 years",
        "color": "Brown",
        "gender": "male",
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T10:00:00.000000Z"
      }
    }
    ```
  - Status Codes: 200 (OK), 404 (Not Found)

- **PUT /pets/{id}**
  - Description: Update a specific pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Body: JSON object with updated pet details (all fields optional)
    ```json
    {
      "name": "string (optional)",
      "species": "string (optional)",
      "age": "string (optional)",
      "color": "string (optional)",
      "gender": "string (optional, enum: male, female)"
    }
    ```
  - Response: JSON with updated pet data
    ```json
    {
      "success": true,
      "message": "Pet updated successfully",
      "data": {
        "id": 1,
        "customer_id": 1,
        "name": "Buddy Updated",
        "species": "Dog",
        "age": "3 years",
        "color": "Brown",
        "gender": "male",
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T11:00:00.000000Z"
      }
    }
    ```
  - Status Codes: 200 (OK), 404 (Not Found), 422 (Validation Error)

- **PATCH /pets/{id}**
  - Description: Partially update a specific pet (same as PUT)
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Body: JSON object with fields to update (all fields optional)
    ```json
    {
      "name": "string (optional)",
      "species": "string (optional)",
      "age": "string (optional)",
      "color": "string (optional)",
      "gender": "string (optional, enum: male, female)"
    }
    ```
  - Response: JSON with updated pet data
    ```json
    {
      "success": true,
      "message": "Pet updated successfully",
      "data": {
        "id": 1,
        "customer_id": 1,
        "name": "Buddy Updated",
        "species": "Dog",
        "age": "3 years",
        "color": "Brown",
        "gender": "male",
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T11:00:00.000000Z"
      }
    }
    ```
  - Status Codes: 200 (OK), 404 (Not Found), 422 (Validation Error)

- **DELETE /pets/{id}**
  - Description: Soft delete a specific pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Response: JSON confirmation
    ```json
    {
      "success": true,
      "message": "Pet deleted successfully",
      "data": "2026-05-03T12:00:00.000000Z"
    }
    ```
  - Status Codes: 200 (OK), 404 (Not Found)

- **POST /pets/{id}/restore**
  - Description: Restore a soft-deleted pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Response: JSON with restored pet data
    ```json
    {
      "success": true,
      "message": "Pet restored successfully",
      "data": {
        "id": 1,
        "customer_id": 1,
        "name": "Buddy",
        "species": "Dog",
        "age": "2 years",
        "color": "Brown",
        "gender": "male",
        "created_at": "2026-05-03T10:00:00.000000Z",
        "updated_at": "2026-05-03T12:00:00.000000Z",
        "deleted_at": null
      }
    }
    ```
  - Status Codes: 200 (OK), 404 (Not Found)

