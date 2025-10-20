@servers(['web' => ['u138686866@153.92.11.65']])

@task('foo', ['on' => 'web'])
    ls -la
@endtask
