<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TodoController extends Controller
{
    /**
     * Get all todos for authenticated user
     */

    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        try {
            $todos = $request->user()
                ->todos()
                ->orderBy('completed')
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $todos,
                'message' => 'Todos retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve todos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new todo
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:255',
            'priority' => 'sometimes|in:low,medium,high',
            'due_date' => 'sometimes|date|after_or_equal:today',
            'category' => 'sometimes|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $todo = $request->user()->todos()->create($request->all());

            return response()->json([
                'success' => true,
                'data' => $todo,
                'message' => 'Todo created successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create todo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single todo
     */
    public function show(Request $request, Todo $todo)
    {
        try {
            $this->authorize('view', $todo);

            return response()->json([
                'success' => true,
                'data' => $todo,
                'message' => 'Todo retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve todo',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * Update a todo
     */
    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $validator = Validator::make($request->all(), [
            'text' => 'sometimes|string|max:255',
            'priority' => 'sometimes|in:low,medium,high',
            'due_date' => 'sometimes|date|after_or_equal:today',
            'category' => 'sometimes|string|max:100',
            'completed' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $todo->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $todo,
                'message' => 'Todo updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update todo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a todo
     */
    public function destroy(Request $request, Todo $todo)
    {
        try {
            $this->authorize('delete', $todo);

            $todo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Todo deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete todo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark todo as complete
     */
    public function complete(Request $request, Todo $todo)
    {
        try {
            $this->authorize('update', $todo);

            $todo->update(['completed' => true]);

            return response()->json([
                'success' => true,
                'data' => $todo,
                'message' => 'Todo marked as complete'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete todo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Archive todo
     */
    public function archive(Request $request, Todo $todo)
    {
        try {
            $this->authorize('update', $todo);

            $todo->update(['archived' => true]);

            return response()->json([
                'success' => true,
                'data' => $todo,
                'message' => 'Todo archived successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to archive todo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get todo statistics
     */
    public function stats(Request $request)
    {
        try {
            $stats = [
                'total' => $request->user()->todos()->count(),
                'completed' => $request->user()->todos()->where('completed', true)->count(),
                'pending' => $request->user()->todos()->where('completed', false)->count(),
                'archived' => $request->user()->todos()->where('archived', true)->count(),
                'categories' => $request->user()->todos()->whereNotNull('category')->distinct('category')->count('category')
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistics retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all categories
     */
    public function categories(Request $request)
    {
        try {
            $categories = $request->user()
                ->todos()
                ->select('category')
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category');

            return response()->json([
                'success' => true,
                'data' => $categories,
                'message' => 'Categories retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}