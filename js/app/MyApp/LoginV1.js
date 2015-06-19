angular.module('app',[]).controller('Login',function($scope,$http){
    $scope.login = function(){

        $http({
            method: 'POST',
            url: base_url+'/endpoint',
            data: {
                    email : $scope.email,
                    password : $scope.password
                }
            }).
        success(function(data, status, headers, config) {
        // called when http call completes successfully
        }).
        error(function(error, status, headers, config) {
        // called when the http call fails.
        // The
        });                        
    }
});
    