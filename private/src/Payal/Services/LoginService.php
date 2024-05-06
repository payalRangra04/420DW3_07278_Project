<?php
declare(strict_types=1);

namespace Payal\Services;

use Exception;
use Payal\DTOs\UserDTO;
use Teacher\GivenCode\Exceptions\RuntimeException;

/**
 * Handles user authentication by managing login sessions and user verifications.
 */
class LoginService {
    private UserService $userService;
    
    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Authenticate a user with a user ID and password.
     *
     * @param int    $userId
     * @param string $password
     * @return bool Returns true if login is successful.
     * @throws RuntimeException
     */
    public function authenticate(int $userId, string $password) : bool {
        try {
            // Retrieve the user by user ID.
            $user = $this->userService->getUserById($userId);
            if (($user !== null) && password_verify($password, $user->getPassword())) {
                $_SESSION['user_id'] = $user->getUserId();
                return true;
            }
            return false;
        } catch (Exception $exp) {
            throw new RuntimeException("Login failed.", 0, $exp);
        }
    }
    
    /**
     * Checks if the user is currently logged in.
     *
     * @return bool Returns true if user is logged in.
     */
    public function isUserLoggedIn() : bool {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Logout the current user.
     */
    public function logout() : void {
        session_destroy();
        $_SESSION = [];
    }
    
    /**
     * Get the currently logged-in user's details.
     *
     * @return UserDTO|null
     * @throws RuntimeException
     */
    public function getCurrentUser() : ?UserDTO {
        if ($this->isUserLoggedIn()) {
            return $this->userService->getUserById((int) $_SESSION['user_id']);
        }
        return null;
    }
}
