<?php
use PHPUnit\Framework\TestCase;

// Import
require_once __DIR__ . '/../model/process/usermodel.php';

class UserModelTest extends TestCase {
    private $conn;

    // Arrange & setup for database connection and data
    protected function setUp(): void {
        // Connect to your local XAMPP database
        $this->conn = mysqli_connect("localhost", "root", "", "greenflag");
        
        if (!$this->conn) {
            $this->markTestSkipped('Database connection failed. Ensure XAMPP is running.');
        }

        // Create a temporary test user before each test to guarantee data exists
        mysqli_query($this->conn, "INSERT INTO users (id, full_name, email, password, role, status) VALUES (9999, 'Test User', 'test@example.com', 'hashedpass', 'student', 'pending')");
    }

    // After every test, remove fake data
    protected function tearDown(): void {
        mysqli_query($this->conn, "DELETE FROM users WHERE id = 9999 OR email = 'newuser@example.com'");
        mysqli_close($this->conn);
    }

    // 1. getAllUsers
    public function testGetAllUsersReturnsData() {
        $result = getAllUsers($this->conn);
        $this->assertGreaterThan(0, mysqli_num_rows($result), "Should return at least our test user.");
    }

    // 2. fetchUserById
    public function testFetchUserByIdReturnsCorrectUser() {
        $user = fetchUserById($this->conn, 9999);
        $this->assertIsArray($user);
        $this->assertEquals('test@example.com', $user['email']);
    }

    // 3. addUser
    public function testAddUserSuccessfullyInserts() {
        $result = addUser($this->conn, 'New User', 'newuser@example.com', 'password123', 'student', 'pending');
        $this->assertTrue($result, "addUser should return true on success.");
        
        // Verify it was actually added
        $check = mysqli_query($this->conn, "SELECT * FROM users WHERE email = 'newuser@example.com'");
        $this->assertEquals(1, mysqli_num_rows($check));
    }

    // 4. editUser
    public function testEditUserUpdatesInformation() {
        $result = editUser($this->conn, 9999, 'Updated Name', 'test@example.com', '', 'admin');
        $this->assertTrue($result);

        $user = fetchUserById($this->conn, 9999);
        $this->assertEquals('Updated Name', $user['full_name']);
        $this->assertEquals('admin', $user['role']);
    }

    // 5. deleteUser
    public function testDeleteUserRemovesRecord() {
        $result = deleteUser($this->conn, 9999);
        $this->assertTrue($result);

        $user = fetchUserById($this->conn, 9999);
        $this->assertNull($user, "User should no longer exist in the database.");
    }

    // 6. updateUserStatus
    public function testUpdateUserStatusChangesStatus() {
        $result = updateUserStatus($this->conn, 9999, 'pending');
        $this->assertTrue($result);

        $user = fetchUserById($this->conn, 9999);
        $this->assertEquals('pending', $user['status']);
    }

    // 7. getAdminCount
    public function testGetAdminCountReturnsInteger() {
        updateUserStatus($this->conn, 9999, 'pending');
        editUser($this->conn, 9999, 'Test User', 'test@example.com', '', 'admin');

        $count = getAdminCount($this->conn);
        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(1, $count);
    }

    // 8. uplicateEmail
    public function testDuplicateEmailDetectsExistingEmail() {
        // Should return true because 'test@example.com' exists (from setUp)
        $isDuplicate = duplicateEmail($this->conn, 'test@example.com');
        $this->assertTrue($isDuplicate);

        // Should return false because it doesn't exist
        $isNotDuplicate = duplicateEmail($this->conn, 'nobody@example.com');
        $this->assertFalse($isNotDuplicate);
        
        // Should return false if we exclude the current user's ID
        $isExcluded = duplicateEmail($this->conn, 'test@example.com', 9999);
        $this->assertFalse($isExcluded);
    }
}
?>