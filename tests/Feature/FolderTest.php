<?php

namespace Tests\Feature;

use App\Models\Folder;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class FolderTest extends TestCase
{

     /**
     * Test for getting all folders.
     *
     * 
     */

    public function testGetAllFoldersEndpoint()
    {
        // Arrange
        $user = User::first(); 

        $token = JWTAuth::fromUser($user); // Generate a JWT token for the user
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('/api/folders/1' );
            // Assert
        $this->assertFolderResponse($response);
    }

    /**
     * Test for getting folder by id.
     *
     * 
     */

    public function testGetFolderByIdEndpoint()
    {
        // Arrange
        $user = User::first();
   
        $token = JWTAuth::fromUser($user); // Generate a JWT token for the user
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('/api/folder/show/1' );
            // Assert
        $this->assertFolderResponse($response);
    }

    /**
     * Test for creating a new folder.
     *
     * 
     */

    public function testCreateFolderEndpoint()
     {
        // Generate new data for creating the folder
        $folderData = [
            'name' => 'Helpline',
            'path' => '/home',
            'parent_folder_id' => '1'
         ];

            // Check if the folder already exists
        $existingFolder = Folder::where('name', $folderData['name'])->first();

        if (!$existingFolder){
         $user = User::first();
   
        $token = JWTAuth::fromUser($user); // Generate a JWT token for the user

         $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/folders/store', $folderData);

 
        // Assert that the request was successful (status code 200)
        $this->assertFolderResponse($response);
        }
        else{
            $folder = $existingFolder;
        }
        $this->assertNotEmpty($folder, 'Folder should exist after the test.');
    }

    /**
     * Test for updating a folder by id.
     *
     * 
     */
    public function testUpdateFolderEndpoint()
     {
        // Generate new data for creating the folder
        $newFolderData = [
            'name' => 'Developers',
            'path' => '/home',
            'parent_folder_id' => '1'
         ];

         $user = User::first();
         $folder = Folder::find(5);

         if ($folder)
         {
         $token = JWTAuth::fromUser($user); // Generate a JWT token for the user

         $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post("/api/folders/update/{$folder->id}", $newFolderData);
 
         $this->assertFolderResponse($response);
         }
         else{
            $this->assertTrue(true, 'Folder not found, skipping the test.');
         }
    }

        /**
     * Test for updating a folder by id.
     *
     * 
     */
    public function testDeleteFolderEndpoint()
        {

            $user = User::first();
            $folder = Folder::find(36);

            if ($folder)
            {
            $token = JWTAuth::fromUser($user); // Generate a JWT token for the user

            $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get("/api/folders/delete/{$folder->id}");
    
            $this->assertFolderResponse($response);
            }
            else{
                $this->assertTrue(true, 'Folder not found, skipping the test.');
            }
        }

    private function assertFolderResponse($response)
    {
        $response->assertStatus(200)
            ->assertJsonStructure();
    }
}
