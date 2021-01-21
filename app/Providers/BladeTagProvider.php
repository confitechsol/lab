<?php

namespace App\Providers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeTagProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('valueof', function ( $expression ) {
            $inputs = explode( ',' , $expression );
            if( count( $inputs ) < 2  ) return '';
            if( count( $inputs ) == 2 ) array_push( $inputs, '""' );

            list( $name, $value, $default ) = $inputs;
            return "<?php echo old( $name ) ?? $value ?? $default ?>";
        });


        Blade::directive('selected', function ( $expression ) {
            return "<?php selected( $expression ); ?>";
        });

        Blade::directive('checked', function ( $expression ) {
            $inputs = explode( ',' , $expression );
            if( count( $inputs ) < 2  ) return '';
            if( count( $inputs ) == 2 ) array_push( $inputs, '""' );

            list( $name, $value, $selected ) = $inputs;
            return "<?php echo ( old( $name ) ?? $selected ) == $value ? ' checked ' : '' ?>";
        });


        Blade::directive('error', function ( $expression ) {
            return "<?php echo \$errors->has( $expression ) ? '<div class=\"error-line my-2 text-danger font-weight-bold\">' . \$errors->first( $expression ) . '</div>' : ''; ?>";
        });

        Blade::directive('isinvalid', function ( $expression ) {
            return "<?php echo \$errors->has( $expression ) ? ' is-invalid ' : ''; ?>";
        });


        Blade::directive('alertdanger', function ( $expression ) {
            return "<div class='alert alert-danger'><?php echo $expression;?></div>";
        });


        Blade::directive('alertwarning', function ( $expression ) {
            return "<div class='alert alert-warning'><?php echo $expression;?></div>";
        });

        Blade::directive('alertinfo', function ( $expression ) {
            return "<div class='alert alert-info'><?php echo $expression;?></div>";
        });

        Blade::directive('alertsuccess', function ( $expression ) {
            return "<div class='alert alert-success'><?php echo $expression;?></div>";
        });

        Blade::directive('image', function ( $expression ) {
            return "<?php echo image( $expression );?>";
        });



        // Array to Recursive Collection
        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}