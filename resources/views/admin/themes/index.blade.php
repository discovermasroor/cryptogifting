@include('admin.head')
    <title>Themes | Dashboard</title>
    <body>
    <div id="preloader" class="d-none"></div>
        @include('admin.header-sidebar')
            <div class="main-content my-beneficiaries">
                <div class="overlay">
                    <div class="main-heading-box flex">
                        <h3>Themes</h3>
                        <a href="{{route('AddTheme')}}" class="btn blue-button">Add Theme</a>
                    </div>
                    <div class="table-responsive data-table-wrapper mt-2">
                        <table class="table">
                            <thead class="heading-box">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th class="action-td">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_themes as $key => $value) { ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$value->title}}</td>
                                        <td class="cover-image" style="background: url(<?php echo $value->cover_image_url;?>);"><p style="height: 100px;width: 100px;"></p></td>
                                        <td class="<?php if ($value->active) echo 'active'; else echo 'cancelled'; ?>"><?php if($value->active) echo 'Active'; else echo 'Not Active'; ?></td>
                                        <td><a href="{{route('EditTheme', [$value->theme_id])}}" class="btn edit-button">Edit</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Daashboard Main Content Ends -->
    </main>
    <style>
        .cover-image {
            background-size: 80px !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
        }
    </style>
@include('admin.footer')