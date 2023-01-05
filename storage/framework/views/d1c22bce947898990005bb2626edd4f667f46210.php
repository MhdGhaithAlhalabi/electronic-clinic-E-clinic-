<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

            <script src="https://cdn.tailwindcss.com"></script>

    </head>

    <body style="background-color: #1a202c">
        <div class="grid h-screen place-items-center">
            <?php if(auth()->guard('admin')->check()): ?>
                <form action="/logout" method="post">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="sm:rounded-lg">logout</button>
                </form>
                <?php else: ?>
                <a href="/login" type="button" class="sm:rounded-lg">login</a>
                 <?php endif; ?>


        </div>








    </body>
</html>
<?php /**PATH E:\projects\Laravel projects\E-clinic\resources\views/welcome.blade.php ENDPATH**/ ?>