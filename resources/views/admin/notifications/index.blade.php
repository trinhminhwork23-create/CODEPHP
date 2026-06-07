@extends('admin.layouts.admin_master')

@section('admin_content')

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="fs-3 mb-1">Tất cả thông báo</h1>
          <p class="mb-0">Theo dõi các hoạt động và sự kiện trong hệ thống</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="list-group list-group-flush">
          @forelse ($notifications ?? [] as $notification)
          <div class="list-group-item list-group-item-action">
            <div class="d-flex gap-3">
              <div class="flex-shrink-0">
                @if($notification->action === 'Create')
                  <div class="avatar avatar-md rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center">
                    <i class="ti ti-plus fs-4"></i>
                  </div>
                @elseif($notification->action === 'Update')
                  <div class="avatar avatar-md rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center">
                    <i class="ti ti-edit fs-4"></i>
                  </div>
                @elseif($notification->action === 'Delete')
                  <div class="avatar avatar-md rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center">
                    <i class="ti ti-trash fs-4"></i>
                  </div>
                @else
                  <div class="avatar avatar-md rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center">
                    <i class="ti ti-bell fs-4"></i>
                  </div>
                @endif
              </div>
              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <h5 class="mb-1 fs-6">
                      @if($notification->action === 'Create')
                        <span class="badge bg-success-subtle text-success me-2">Tạo mới</span>
                      @elseif($notification->action === 'Update')
                        <span class="badge bg-warning-subtle text-warning me-2">Cập nhật</span>
                      @elseif($notification->action === 'Delete')
                        <span class="badge bg-danger-subtle text-danger me-2">Xóa</span>
                      @endif
                      {{ $notification->target_model }}
                    </h5>
                    <p class="mb-1 text-muted">{{ $notification->description }}</p>
                    <small class="text-secondary">
                      <i class="ti ti-user me-1"></i>{{ $notification->user_name }}
                      @if($notification->role)
                        <span class="badge bg-light text-dark ms-1">{{ $notification->role }}</span>
                      @endif
                    </small>
                  </div>
                  <small class="text-muted text-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="list-group-item text-center py-5">
            <i class="ti ti-bell-off fs-1 text-muted mb-3"></i>
            <p class="text-muted mb-0">Chưa có thông báo nào</p>
          </div>
          @endforelse
        </div>
      </div>

      @if($notifications->hasPages())
      <div class="mt-4">
        {{ $notifications->links() }}
      </div>
      @endif
    </div>
  </div>
</div>

@endsection
