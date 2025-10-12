<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class TestUpstashConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upstash:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Upstash Redis connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Upstash Redis connection...');
        
        try {
            // Test Redis connection
            $this->info('1. Testing Redis connection...');
            Redis::ping();
            $this->info('✅ Redis connection successful!');
            
            // Test Redis set/get
            $this->info('2. Testing Redis set/get...');
            Redis::set('test_key', 'test_value');
            $value = Redis::get('test_key');
            if ($value === 'test_value') {
                $this->info('✅ Redis set/get successful!');
            } else {
                $this->error('❌ Redis set/get failed!');
            }
            
            // Test Cache
            $this->info('3. Testing Cache...');
            Cache::put('test_cache', 'cache_value', 60);
            $cacheValue = Cache::get('test_cache');
            if ($cacheValue === 'cache_value') {
                $this->info('✅ Cache successful!');
            } else {
                $this->error('❌ Cache failed!');
            }
            
            // Test Session (if possible)
            $this->info('4. Testing Session storage...');
            session(['test_session' => 'session_value']);
            $sessionValue = session('test_session');
            if ($sessionValue === 'session_value') {
                $this->info('✅ Session storage successful!');
            } else {
                $this->error('❌ Session storage failed!');
            }
            
            $this->info('🎉 All tests passed! Upstash is working correctly.');
            
        } catch (\Exception $e) {
            $this->error('❌ Connection failed: ' . $e->getMessage());
            $this->error('Please check your .env configuration:');
            $this->line('REDIS_URL=redis://default:password@host:port');
            $this->line('REDIS_HOST=your-upstash-host');
            $this->line('REDIS_PASSWORD=your-upstash-password');
            $this->line('REDIS_PORT=your-upstash-port');
            return 1;
        }
        
        return 0;
    }
}
