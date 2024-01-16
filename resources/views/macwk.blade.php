@extends('layouts.app')

@section('content')

    <div class="max-w-screen-xl mx-auto ">
      <!-- 顶部导航 -->
      <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <!-- 左侧logo和菜单项 -->
            <div class="flex">
              <div class="flex-shrink-0 flex items-center">
                <img class="h-8 w-8" src="https://via.placeholder.com/64" alt="Logo">
              </div>
              <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                <!-- 导航链接 -->
              </div>
            </div>
            <!-- 右侧内容 -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
              <!-- 配置项 -->
            </div>
          </div>
        </div>
      </nav>

      <!-- 主体内容 -->
      <main class="mt-8 p-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex flex-col md:flex-row">
              <!-- 图片占位符 -->
              <div class="flex-1">
                <img src="https://via.placeholder.com/300" alt="Placeholder" class="w-full h-auto">
              </div>
              <!-- 文字内容 -->
              <div class="flex-1 space-y-4 p-4">
                <h2 class="text-lg leading-6 font-medium text-gray-900">Microsoft Remote Desktop 10.7.3</h2>
                <p class="mt-1 text-sm text-gray-600">
                  用于连接Windows的远程桌面工具。
                </p>
                <!-- 其他信息 -->
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

@endsection
