'use strict';

/**
 * @ngdoc service
 * @name clientApp.errorLogService
 * @description
 * # errorLogService
 * Factory in the clientApp.
 */
angular.module('clientApp')
  .factory('ErrorLog', function ($log, $window, StackTrace, Config) {
    // Log the given error to the remote server.
    function log(exception, cause) {

      // Pass off the error to the default error handler
      // on the AngualrJS logger. This will output the
      // error to the console (and let the application
      // keep running normally for the user).
      $log.error.apply( $log, arguments );

      // Log the error the server.
      try {

        var errorMessage = exception.toString();
        var stackTrace = StackTrace.print({ e: exception });

        var data = {
          errorUrl: $window.location.href,
          errorMessage: errorMessage,
          stackTrace: stackTrace,
          cause: cause || ''
        };

        // Log the JavaScript error to the server. We use jQuery Ajax and not
        // $http, to avoid failures.
        $.ajax({
          type: 'POST',
          dataType: 'jsonp',
          url: Config.logUrl,
          contentType: 'application/json',
          data: data
        });
      }
      catch (loggingError) {
        // For Developers - log the log-failure.
        $log.warn( "Error logging failed" );
        $log.log( loggingError );

      }
    }

    // Return the logging function.
    return( log );
  });
