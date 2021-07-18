<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('username', __('用户名'));
        $grid->column('nickname', __('昵称'));
        $grid->column('avatar', __('头像'));
        $grid->column('phone', __('电话'));
        $grid->column('email', __('邮件'));
        $grid->column('email_verified_at', '邮箱已验证？')->display(function ($released) {
            return $released ? '是' : '否';
        });
        //$grid->column('email_verified_at', __('Email verified at'));
        //$grid->column('password', __('密码'));
        $grid->column('introduction', __('自我介绍'));
        //$grid->column('provider', __('Provider'));
        //$grid->column('provider_id', __('Provider id'));
        //$grid->column('notification_count', __('Notification count'));
       // $grid->column('remember_token', __('Remember token'));
        $grid->column('created_at', __('注册时间'));
        //$grid->column('updated_at', __('Updated at'));
        $grid->disableCreateButton();
        // 同时在每一行也不显示 `编辑` 按钮
        $grid->disableActions();
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('nickname', __('Nickname'));
        $show->field('avatar', __('Avatar'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('introduction', __('Introduction'));
        $show->field('provider', __('Provider'));
        $show->field('provider_id', __('Provider id'));
        $show->field('notification_count', __('Notification count'));
        $show->field('remember_token', __('Remember token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('username', __('Username'));
        $form->text('nickname', __('Nickname'));
        $form->textarea('avatar', __('Avatar'));
        $form->mobile('phone', __('Phone'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('introduction', __('Introduction'));
        $form->text('provider', __('Provider'));
        $form->text('provider_id', __('Provider id'));
        $form->number('notification_count', __('Notification count'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
