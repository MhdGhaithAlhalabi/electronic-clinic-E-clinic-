@extends('layout')
@section('title','- doctors')
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
                                non-activated doctors
                            </h1>
                            <div class="overflow-x-auto relative">
                                <table id="example1"
                                       class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            doctor name
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            mobile_number
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            clinic_number
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            specialization
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            city
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            image
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            certificate_image
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            location
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            addriss
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            certificate_number
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            active
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($doctors as $doctor)
                                        @if($doctor->status != 1)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap 				dark:text-white">
                                                    {{$doctor->name}}
                                                </th>
                                                <td class="py-4 px-6">
                                                    {{$doctor->mobile_number}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{$doctor->clinic_number}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{$doctor->specialization->name}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{$doctor->city->name}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    <img style="width: 200px;height: 200px" src="{{$doctor->image}}"
                                                         alt="image">
                                                </td>
                                                <td class="py-4 px-6">
                                                    <img style="width: 200px;height: 200px"
                                                         src="{{$doctor->certificate_image}}" alt="image">
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div id="map" style="width: 200px;height: 200px"></div>
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{$doctor->full_address}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{$doctor->certificate_number}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    <form method="post"
                                                          action="{{url('doctorApprove',$doctor->id)}}">
                                                        @csrf
                                                        <button type="submit"
                                                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                            active
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div
                        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                activated doctors
                            </h1>
                            <div class="overflow-x-auto relative">
                                <table id="example2" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">
                                            doctor name
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            mobile_number
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            specialization
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            city
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            image
                                        </th>
                                        <th scope="col" class="py-3 px-6">
                                            certificate_image
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($doctors as $doctor)
                                        @if($doctor->status == 1)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{$doctor->name}}
                                                </th>

                                                <td class="py-4 px-6">
                                                    {{$doctor->mobile_number}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{$doctor->specialization->name}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{$doctor->city->name}}
                                                </td>
                                                <td class="py-4 px-6">
                                                    <img style="width: 200px;height: 200px" src="{{$doctor->image }}"
                                                         alt="image">
                                                </td>
                                                <td class="py-4 px-6">
                                                    <img style="width: 200px;height: 200px"
                                                         src="{{$doctor->certificate_image }}" alt="image">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

