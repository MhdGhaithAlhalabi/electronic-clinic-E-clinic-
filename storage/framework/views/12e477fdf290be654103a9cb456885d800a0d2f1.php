<?php $__env->startSection('title','- complaint'); ?>

<?php $__env->startSection('content'); ?>

    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div
                class="w-full bg-gray-100 text-gray-500  rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">

                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div
                        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                all complaint
                            </h1>
                            <div class="overflow-x-auto relative">
                                <table id="example1" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            type
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            body
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            date
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            patient name phone
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            consultation title  status date name_doctor
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            block patient
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            doctor name phone
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            block doctor
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php echo e($complaint->type); ?>

                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php echo e($complaint->body); ?>

                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php echo e($complaint->created_at->diffForHumans()); ?>

                                            </td>
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php echo e($complaint->patient->name); ?>,
                                                <?php echo e($complaint->patient->personal->mobile_number); ?>,
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php $__currentLoopData = $complaint->patient->consultation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($c->title); ?> ,
                                                    <?php echo e($c->status); ?> ,
                                                    <?php echo e($c->created_at->diffForHumans()); ?> ,
                                                <?php if($c->doctor): ?>
                                                    <?php echo e($c->doctor->name); ?>

                                                    <?php endif; ?>
                                                    <br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php if($complaint->patient->status == 1): ?>
                                                    <form method="post"
                                                          action="<?php echo e(url('patientBlock',$complaint->patient->id)); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit"
                                                                class="text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                            block
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <form method="post"
                                                          action="<?php echo e(url('patientUnblock',$complaint->patient->id)); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit"
                                                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                            unBlock
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php if($complaint->doctor): ?>
                                                    <?php echo e($complaint->doctor->name); ?>,
                                                    <?php echo e($complaint->doctor->mobile_number); ?>

                                                <?php endif; ?>
                                            </td>

                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <?php if($complaint->doctor): ?>
                                                    <?php if($complaint->doctor->status == 1): ?>

                                                        <form method="post"
                                                              action="<?php echo e(url('doctorBlock',$complaint->doctor->id)); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                    class="text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                                block
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form method="post"
                                                              action="<?php echo e(url('doctorApprove',$complaint->doctor->id)); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                                unBlock
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div
                class="w-full bg-gray-100 text-gray-500  rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">

                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div
                        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                complaint chart
                            </h1>
                            <div class="overflow-x-auto relative">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var labels = <?php echo e(Js::from($labels)); ?>;
        var other =   <?php echo e(Js::from($other)); ?>;
        var waiting =   <?php echo e(Js::from($waiting)); ?>;
        var doctor =   <?php echo e(Js::from($doctor)); ?>;
        
        
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'other',
                        data: other,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                     },
                    {
                        label: 'waiting',
                        data: waiting,
                        fill: false,
                        borderColor: 'rgb(136, 8, 8)',
                        tension: 0.1
                    },
                    {
                        label: 'doctor',
                        data: doctor,
                        fill: false,
                        borderColor: 'rgb(21,20,20)',
                        tension: 0.1
                    }
                    ],
                    // {
                    //     label: 'finish',
                    //     data: speed,
                    //     fill: false,
                    //     borderColor: 'rgb(136, 8, 8)',
                    //     tension: 0.1
                    // },
                    // {
                    //     label: 'other',
                    //     data: speed,
                    //     fill: false,
                    //     borderColor: 'rgb(21,20,20)',
                    //     tension: 0.1
                    // }

            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\projects\Laravel projects\E-clinic\resources\views/complaint.blade.php ENDPATH**/ ?>