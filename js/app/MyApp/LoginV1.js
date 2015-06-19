angular.module('app',[]).controller('Login',function($scope,$http){
    $scope.login = function(){
        console.log($scope);
        
        $http({
            method: 'POST',
            url: base_url+'/Login/acceder',
            data: {
                    email : $scope.email,
                    password : $scope.password
                },            
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
    