## API Documentation

This API is built with Laravel and uses Sanctum for authentication.

### Base URL
`http://your-domain.com/api`

### Authentication
Most endpoints require authentication using Laravel Sanctum. Include the Bearer token in the Authorization header: `Authorization: Bearer {token}`.

### Endpoints

#### Authentication Endpoints

- **POST /register**
  - Description: Register a new user
  - Body: JSON object with user registration details (e.g., name, email, password)
  - Response: JSON with user data and access token
  - Status Codes: 201 (Created), 422 (Validation Error)

- **POST /login**
  - Description: Authenticate user and get access token
  - Body: JSON object with email and password
  - Response: JSON with user data and access token
  - Status Codes: 200 (OK), 401 (Unauthorized)

#### Protected Endpoints (Require Authentication)

- **POST /logout**
  - Description: Logout the authenticated user (invalidate token)
  - Headers: `Authorization: Bearer {token}`
  - Response: JSON confirmation
  - Status Codes: 200 (OK)

- **GET /profile**
  - Description: Get the authenticated user's profile
  - Headers: `Authorization: Bearer {token}`
  - Response: JSON with user profile data
  - Status Codes: 200 (OK)

- **PUT /edit-profile**
  - Description: Update the authenticated user's profile
  - Headers: `Authorization: Bearer {token}`
  - Body: JSON object with fields to update
  - Response: JSON with updated user data
  - Status Codes: 200 (OK), 422 (Validation Error)

- **PATCH /edit-profile**
  - Description: Partially update the authenticated user's profile (same as PUT)
  - Headers: `Authorization: Bearer {token}`
  - Body: JSON object with fields to update
  - Response: JSON with updated user data
  - Status Codes: 200 (OK), 422 (Validation Error)

#### Pets Resource (CRUD Operations)

- **GET /pets**
  - Description: List all pets belonging to the authenticated user
  - Headers: `Authorization: Bearer {token}`
  - Response: JSON array of pets
  - Status Codes: 200 (OK)

- **POST /pets**
  - Description: Create a new pet for the authenticated user
  - Headers: `Authorization: Bearer {token}`
  - Body: JSON object with pet details
  - Response: JSON with created pet data
  - Status Codes: 201 (Created), 422 (Validation Error)

- **GET /pets/{id}**
  - Description: Get details of a specific pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Response: JSON with pet data
  - Status Codes: 200 (OK), 404 (Not Found)

- **PUT /pets/{id}**
  - Description: Update a specific pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Body: JSON object with updated pet details
  - Response: JSON with updated pet data
  - Status Codes: 200 (OK), 404 (Not Found), 422 (Validation Error)

- **PATCH /pets/{id}**
  - Description: Partially update a specific pet (same as PUT)
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Body: JSON object with fields to update
  - Response: JSON with updated pet data
  - Status Codes: 200 (OK), 404 (Not Found), 422 (Validation Error)

- **DELETE /pets/{id}**
  - Description: Soft delete a specific pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Response: JSON confirmation
  - Status Codes: 200 (OK), 404 (Not Found)

- **POST /pets/{id}/restore**
  - Description: Restore a soft-deleted pet
  - Headers: `Authorization: Bearer {token}`
  - Parameters: `id` (integer) - Pet ID
  - Response: JSON with restored pet data
  - Status Codes: 200 (OK), 404 (Not Found)

