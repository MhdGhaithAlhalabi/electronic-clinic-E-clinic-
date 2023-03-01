@extends('layout')
@section('title','- complaint')
@section('content')
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
                                            consultation title status date name_doctor
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
                                    @foreach($complaints as $complaint)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$complaint->type}}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$complaint->body}}
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$complaint->created_at->diffForHumans() }}
                                            </td>
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$complaint->patient->name}},
                                                {{$complaint->patient->personal->mobile_number}},
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                @foreach($complaint->patient->consultation as $c)
                                                    {{$c->title}} ,
                                                    {{$c->status}} ,
                                                    {{$c->created_at->diffForHumans() }} ,
                                                    @if($c->doctor)
                                                        {{$c->doctor->name}}
                                                    @endif
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                @if($complaint->patient->status == 1)
                                                    <form method="post"
                                                          action="{{url('patientBlock',$complaint->patient->id)}}">
                                                        @csrf
                                                        <button type="submit"
                                                                class="text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                            block
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="post"
                                                          action="{{url('patientUnblock',$complaint->patient->id)}}">
                                                        @csrf
                                                        <button type="submit"
                                                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                            unBlock
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                @if($complaint->doctor)
                                                    {{$complaint->doctor->name}},
                                                    {{$complaint->doctor->mobile_number}}
                                                @endif
                                            </td>
                                            <td scope="row"
                                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                @if($complaint->doctor)
                                                    @if($complaint->doctor->status == 1)
                                                        <form method="post"
                                                              action="{{url('doctorBlock',$complaint->doctor->id)}}">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                                block
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="post"
                                                              action="{{url('doctorApprove',$complaint->doctor->id)}}">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                                unBlock
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var labels = {{ Js::from($labels) }};
        var other = {{ Js::from($other) }};
        var waiting = {{ Js::from($waiting) }};
        var doctor = {{ Js::from($doctor) }};
        {{--var finish = {{ Js::from($finish) }};--}}
        {{--var other = {{ Js::from($other) }};--}}
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
@stop
