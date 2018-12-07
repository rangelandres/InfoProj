/*
 * Controller where we get the data on accounts
 */
(function () {
    'use strict';
    
    // the 'cstutors' part comes from the name of the app we created in cstutors.module.js
    var myApp = angular.module("cstutors");
    
    // 'dataControl' is used in the html file when defning the ng-controller attribute
    myApp.controller("dataControl", function($scope, $http, $window) {
        
        // define data for the app
        // in the html code we will refer to data.accounts. The data part comes from $scope.data, the accounts part comes from the JSON object below
        $http.get('getstudents.php')
            .then(function(response) {
                // response.data.value has value come from the getstudents.php file $response['value']['students'] = $students;
                $scope.data = response.data.value;
            }
                   );
        //gets students in cs1020    
        $http.get('getstudents1020.php')
            .then(function(response) {
                // response.data.value has value come from the getstudents.php file $response['value']['students'] = $students;
                $scope.data1020 = response.data.value;
            }
                   );
        //gets students in cs1110    
        $http.get('getstudents1110.php')
            .then(function(response) {
                // response.data.value has value come from the getstudents.php file $response['value']['students'] = $students;
                $scope.data1110 = response.data.value;
            }
                   );
            
        //gets posts for cs:1210
        $http.get('getpost.php')
            .then(function(response) {
                // response.data.value has value come from the getstudents.php file $response['value']['students'] = $students;
                $scope.post = response.data.value;
            }
                   );
            
        //gets posts for cs:1110
        $http.get('getpost1110.php')
            .then(function(response) {
                // response.data.value has value come from the getstudents.php file $response['value']['students'] = $students;
                $scope.post1110 = response.data.value;
            }
                   );
        //gets posts for cs:1020
        $http.get('getpost1020.php')
            .then(function(response) {
                // response.data.value has value come from the getstudents.php file $response['value']['students'] = $students;
                $scope.post1020 = response.data.value;
            }
                   );
        
        //gets data from account table    
        $http.get('getaccounts.php')
            .then(function(response) {
                // response.data.value has value come from the getaccounts.php file $response['value']['accounts'] = $accounts;
                $scope.data2 = response.data.value;
            }
                   );
        
        //gets data from account table    
        $http.get('getcourses.php')
            .then(function(response) {
                // response.data.value has value come from the getaccounts.php file $response['value']['accounts'] = $accounts;
                $scope.data3 = response.data.value;
            }
                   );
        
        //gets hawkid
       $http.get('isloggedin.php')
            .then(function(response) {
                // response.data.value has value come from the isloggedin.php file $response['value']['isloggedin'] = $isloggedin;
                $scope.datahawk = response.data.hawkid;

            }
                   );           
        
        // function to delete an account. it receives the account's name and id and call a php web api to complete deletion from the database
        $scope.deleteAccount = function(name, hawkid) {
            if (confirm("Are you sure you want to delete " + name + "?")) {
          
                $http.post("deleteaccount.php", {"hawkid" : hawkid})
                  .then(function (response) {
                     if (response.status == 200) {
                          if (response.data.status == 'error') {
                              alert('error: ' + response.data.message);
                          } else {
                              // successful
                              // send user back to home page
                              $window.location.href = "adminaccounts.html";
                          }
                     } else {
                          alert('unexpected error');
                     }
                  }
                );
            }
        };
        
    
        
        
        // function to send new account information to web api to add it to the database
        $scope.newAccount = function(accountDetails) {
          var accountupload = angular.copy(accountDetails);
          
          $http.post("newaccount.php", accountupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "adminaccounts.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };        
        
        // function to send new account information to web api to add it to the database
        $scope.login = function(accountDetails) {
          var accountupload = angular.copy(accountDetails);
          
          $http.post("login.php", accountupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // sends user depending on account type
                        
                        if (response.data.administrator == true) {
                        $window.location.href = "adminhome.html";
                        }
                    
                        if (response.data.faculty == true) {
                            $window.location.href = "facultyhome.html";
                        }
   
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        
        // function to log the user out
        $scope.logout = function() {
          $http.post("logout.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "../home.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };             
        
        // function to check if user is logged in
        $scope.checkifloggedin = function() {
          $http.post("isloggedin.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                        
                    } else {
                        // successful
                        // set $scope.isloggedin based on whether the user is logged in or not
                        $scope.isloggedin = response.data.loggedin;
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        //checks if in course cs:1210
        $scope.checkCourse1210 = function() {
          $http.post("isCourse1.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                        
                    } else {
                        // successful
                        // set $scope.isloggedin based on whether the user is logged in or not
                        $scope.isCourse1210 = response.data.c1210;
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        //checks if in course cs: 1020
        $scope.checkCourse1020 = function() {
          $http.post("isCourse1.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                        
                    } else {
                        // successful
                        // set $scope.isloggedin based on whether the user is logged in or not
                        $scope.isCourse1020 = response.data.c1020;
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        
        //checks if in course cs: 1110
        $scope.checkCourse1110 = function() {
          $http.post("isCourse1.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                        
                    } else {
                        // successful
                        // set $scope.isloggedin based on whether the user is logged in or not
                        $scope.isCourse1110 = response.data.c1110;
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        //checks if user is admin
        $scope.checkifadmin = function() {
          $http.post("isAdmin.php")
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                        
                    } else {
                        // successful
                        // set $scope.isloggedin based on whether the user is admin in or not
                        $scope.isadmin = response.data.isadmin;
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        
        //posts new post in class 1210
        $scope.newPost1210 = function(postDetail) {
            var postupload = angular.copy(postDetail);
          
          $http.post("newpost.php", postupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "course1210.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };   

        //posts new post in class 1110
       $scope.newPost1110 = function(postDetail) {
          var postupload = angular.copy(postDetail);
          
          $http.post("newpost1110.php", postupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "course1110.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
        //posts new post in class 1020
       $scope.newPost1020 = function(postDetail) {
          var postupload = angular.copy(postDetail);
          
          $http.post("newpost1020.php", postupload)
            .then(function (response) {
               if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error: ' + response.data.message);
                    } else {
                        // successful
                        // send user back to home page
                        $window.location.href = "course1020.html";
                    }
               } else {
                    alert('unexpected error');
               }
            });                        
        };
        
    });
    
    
} )();
