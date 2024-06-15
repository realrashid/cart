<?php

/**
 * Check if the function 'cart' is already defined.
 * If not, define it.
 */
if (! function_exists('cart')) {

    /**
     * Returns an instance of the Cart class.
     *
     * This function provides a convenient way to access the Cart instance
     * using a globally available function. It retrieves the 'cart' instance
     * from the application container and returns it.
     *
     *
     * @return \RealRashid\Cart\Cart The Cart instance.
     *
     * @author Rashid Ali <realrashid05@gmail.com>
     */
    function cart()
    {
        return app('cart');
    }
}
