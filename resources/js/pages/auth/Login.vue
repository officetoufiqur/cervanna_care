<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';

// Props from parent (if needed)
defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();

// Reactive login form
const form = useForm({
    email: 'admin@gmail.com',
    password: 'password',
    remember: false,
});
</script>

<template>
  <AuthBase
    title="Log in to your account"
    description="Enter your email and password below to log in"
  >
    <Head title="Log in" />

    <!-- Status message -->
    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <!-- Login Form -->
    <form v-bind="form" @submit.prevent="form.post('/login')" class="flex flex-col gap-6">
      <div class="grid gap-6">

        <!-- Email Field -->
        <div class="grid gap-2">
          <Label for="email">Email address</Label>
          <Input
            id="email"
            type="email"
            name="email"
            v-model="form.email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
          />
          <InputError :message="form.errors.email" />
        </div>

        <!-- Password Field -->
        <div class="grid gap-2">
          <div class="flex items-center justify-between">
            <Label for="password">Password</Label>
            <TextLink
              v-if="canResetPassword"
              :href="request()"
              class="text-sm"
            >
              Forgot password?
            </TextLink>
          </div>
          <Input
            id="password"
            type="password"
            name="password"
            v-model="form.password"
            required
            autocomplete="current-password"
            placeholder="Password"
          />
          <InputError :message="form.errors.password" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center space-x-3">
          <Checkbox id="remember" name="remember" v-model="form.remember" />
          <Label for="remember">Remember me</Label>
        </div>

        <!-- Submit Button -->
        <Button
          type="submit"
          class="w-full bg-[#56284f] hover:bg-[#56284f]/90 py-5"
          :disabled="form.processing"
        >
          <Spinner v-if="form.processing" />
          Log in
        </Button>

      </div>

      <!-- Registration Link -->
      <div class="text-center text-sm text-muted-foreground" v-if="canRegister">
        Don't have an account?
        <TextLink :href="register()">Sign up</TextLink>
      </div>
    </form>
  </AuthBase>
</template>
