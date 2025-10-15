// Flutter API Implementation Examples for Luxe Hair Studio
// This file contains ready-to-use Dart/Flutter code for API integration

// ============================================================================
// DEPENDENCIES
// ============================================================================
// Add these to your pubspec.yaml:
//
// dependencies:
//   http: ^1.1.0
//   flutter_secure_storage: ^9.0.0
//   provider: ^6.1.1  # or your preferred state management
//
// ============================================================================

import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

// ============================================================================
// CONFIGURATION
// ============================================================================

class ApiConfig {
  // Android Emulator
  static const String baseUrlAndroid = 'http://10.0.2.2:8000/api';
  
  // iOS Simulator
  static const String baseUrlIOS = 'http://127.0.0.1:8000/api';
  
  // Physical Device (replace with your computer's IP)
  static const String baseUrlPhysical = 'http://YOUR_IP_HERE:8000/api';
  
  // Auto-detect platform
  static String get baseUrl {
    // You can use Platform.isAndroid to auto-detect
    return baseUrlAndroid; // Change based on your testing platform
  }
}

// ============================================================================
// MODELS
// ============================================================================

class User {
  final int id;
  final String name;
  final String email;
  final String role;
  final DateTime createdAt;
  final DateTime updatedAt;

  User({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
    required this.createdAt,
    required this.updatedAt,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      role: json['role'],
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'role': role,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}

class AuthResponse {
  final User user;
  final String token;

  AuthResponse({required this.user, required this.token});

  factory AuthResponse.fromJson(Map<String, dynamic> json) {
    return AuthResponse(
      user: User.fromJson(json['user']),
      token: json['token'],
    );
  }
}

class Service {
  final String id;
  final String name;
  final String slug;
  final String category;
  final String? description;
  final double price;
  final int duration;
  final bool active;
  final String visibility;
  final String? image;
  final List<String>? features;
  final List<String>? tags;
  final DateTime createdAt;
  final DateTime updatedAt;

  Service({
    required this.id,
    required this.name,
    required this.slug,
    required this.category,
    this.description,
    required this.price,
    required this.duration,
    required this.active,
    required this.visibility,
    this.image,
    this.features,
    this.tags,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Service.fromJson(Map<String, dynamic> json) {
    return Service(
      id: json['_id'],
      name: json['name'],
      slug: json['slug'],
      category: json['category'],
      description: json['description'],
      price: (json['price'] ?? 0).toDouble(),
      duration: json['duration'] ?? 0,
      active: json['active'] ?? false,
      visibility: json['visibility'] ?? 'public',
      image: json['image'],
      features: json['features'] != null 
          ? List<String>.from(json['features']) 
          : null,
      tags: json['tags'] != null 
          ? List<String>.from(json['tags']) 
          : null,
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }
}

class Deal {
  final String id;
  final String dealName;
  final String? description;
  final double discountPercentage;
  final DateTime startDate;
  final DateTime endDate;
  final bool isActive;
  final String? serviceId;
  final String? terms;
  final int? maxUses;
  final int? currentUses;
  final DateTime createdAt;
  final DateTime updatedAt;

  Deal({
    required this.id,
    required this.dealName,
    this.description,
    required this.discountPercentage,
    required this.startDate,
    required this.endDate,
    required this.isActive,
    this.serviceId,
    this.terms,
    this.maxUses,
    this.currentUses,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Deal.fromJson(Map<String, dynamic> json) {
    return Deal(
      id: json['_id'],
      dealName: json['DealName'],
      description: json['Description'],
      discountPercentage: (json['DiscountPercentage'] ?? 0).toDouble(),
      startDate: DateTime.parse(json['StartDate']),
      endDate: DateTime.parse(json['EndDate']),
      isActive: json['IsActive'] ?? false,
      serviceId: json['ServiceID'],
      terms: json['Terms'],
      maxUses: json['MaxUses'],
      currentUses: json['CurrentUses'],
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }

  bool get isAvailable {
    if (!isActive) return false;
    final now = DateTime.now();
    if (now.isBefore(startDate) || now.isAfter(endDate)) return false;
    if (maxUses != null && currentUses != null && currentUses! >= maxUses!) {
      return false;
    }
    return true;
  }
}

class PaginatedResponse<T> {
  final List<T> data;
  final int currentPage;
  final int lastPage;
  final int perPage;
  final int total;
  final String message;

  PaginatedResponse({
    required this.data,
    required this.currentPage,
    required this.lastPage,
    required this.perPage,
    required this.total,
    required this.message,
  });
}

// ============================================================================
// API SERVICE
// ============================================================================

class ApiService {
  final storage = const FlutterSecureStorage();
  
  // Token management
  Future<void> saveToken(String token) async {
    await storage.write(key: 'auth_token', value: token);
  }

  Future<String?> getToken() async {
    return await storage.read(key: 'auth_token');
  }

  Future<void> deleteToken() async {
    await storage.delete(key: 'auth_token');
  }

  // Headers
  Future<Map<String, String>> _getHeaders({bool requiresAuth = false}) async {
    final headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (requiresAuth) {
      final token = await getToken();
      if (token != null) {
        headers['Authorization'] = 'Bearer $token';
      }
    }

    return headers;
  }

  // Error handling
  void _handleError(http.Response response) {
    if (response.statusCode >= 400) {
      final body = jsonDecode(response.body);
      throw Exception(body['message'] ?? 'An error occurred');
    }
  }

  // ============================================================================
  // AUTHENTICATION METHODS
  // ============================================================================

  /// Register a new user
  Future<AuthResponse> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/register'),
      headers: await _getHeaders(),
      body: jsonEncode({
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': passwordConfirmation,
      }),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    final authResponse = AuthResponse.fromJson(data);
    
    // Save token
    await saveToken(authResponse.token);
    
    return authResponse;
  }

  /// Login user
  Future<AuthResponse> login({
    required String email,
    required String password,
  }) async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/login'),
      headers: await _getHeaders(),
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    final authResponse = AuthResponse.fromJson(data);
    
    // Save token
    await saveToken(authResponse.token);
    
    return authResponse;
  }

  /// Get authenticated user
  Future<User> getUser() async {
    final response = await http.get(
      Uri.parse('${ApiConfig.baseUrl}/user'),
      headers: await _getHeaders(requiresAuth: true),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return User.fromJson(data);
  }

  /// Logout (current device)
  Future<void> logout() async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/logout'),
      headers: await _getHeaders(requiresAuth: true),
    );

    _handleError(response);

    // Delete local token
    await deleteToken();
  }

  /// Logout from all devices
  Future<void> logoutAll() async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/logout-all'),
      headers: await _getHeaders(requiresAuth: true),
    );

    _handleError(response);

    // Delete local token
    await deleteToken();
  }

  /// Check if user is authenticated
  Future<bool> isAuthenticated() async {
    final token = await getToken();
    if (token == null) return false;

    try {
      await getUser();
      return true;
    } catch (e) {
      await deleteToken();
      return false;
    }
  }

  // ============================================================================
  // SERVICES METHODS
  // ============================================================================

  /// Get all services with pagination
  Future<PaginatedResponse<Service>> getServices({
    String? category,
    String? searchQuery,
    List<String>? tags,
    bool? activeOnly,
    String? visibility,
    String sortBy = 'created_at',
    String sortOrder = 'desc',
    int perPage = 15,
    int page = 1,
  }) async {
    final queryParams = <String, String>{
      'sort_by': sortBy,
      'sort_order': sortOrder,
      'per_page': perPage.toString(),
      'page': page.toString(),
    };

    if (category != null) queryParams['category'] = category;
    if (searchQuery != null) queryParams['q'] = searchQuery;
    if (tags != null && tags.isNotEmpty) {
      queryParams['tags'] = tags.join(',');
    }
    if (activeOnly != null) queryParams['active'] = activeOnly.toString();
    if (visibility != null) queryParams['visibility'] = visibility;

    final uri = Uri.parse('${ApiConfig.baseUrl}/services')
        .replace(queryParameters: queryParams);

    final response = await http.get(
      uri,
      headers: await _getHeaders(),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    final services = (data['data'] as List)
        .map((json) => Service.fromJson(json))
        .toList();

    return PaginatedResponse<Service>(
      data: services,
      currentPage: data['meta']['current_page'],
      lastPage: data['meta']['last_page'],
      perPage: data['meta']['per_page'],
      total: data['meta']['total'],
      message: data['message'],
    );
  }

  /// Get public active services (cached)
  Future<List<Service>> getPublicServices() async {
    final response = await http.get(
      Uri.parse('${ApiConfig.baseUrl}/services/public'),
      headers: await _getHeaders(),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return (data['data'] as List)
        .map((json) => Service.fromJson(json))
        .toList();
  }

  /// Get single service by ID
  Future<Service> getService(String id) async {
    final response = await http.get(
      Uri.parse('${ApiConfig.baseUrl}/services/$id'),
      headers: await _getHeaders(),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return Service.fromJson(data['data']);
  }

  // ============================================================================
  // DEALS METHODS
  // ============================================================================

  /// Get all deals with pagination
  Future<PaginatedResponse<Deal>> getDeals({
    String? serviceId,
    bool activeOnly = true,
    String sortBy = 'created_at',
    String sortOrder = 'desc',
    int perPage = 15,
    int page = 1,
  }) async {
    final queryParams = <String, String>{
      'active_only': activeOnly.toString(),
      'sort_by': sortBy,
      'sort_order': sortOrder,
      'per_page': perPage.toString(),
      'page': page.toString(),
    };

    if (serviceId != null) queryParams['service_id'] = serviceId;

    final uri = Uri.parse('${ApiConfig.baseUrl}/deals')
        .replace(queryParameters: queryParams);

    final response = await http.get(
      uri,
      headers: await _getHeaders(),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    final deals = (data['data'] as List)
        .map((json) => Deal.fromJson(json))
        .toList();

    return PaginatedResponse<Deal>(
      data: deals,
      currentPage: data['meta']['current_page'],
      lastPage: data['meta']['last_page'],
      perPage: data['meta']['per_page'],
      total: data['meta']['total'],
      message: data['message'],
    );
  }

  /// Get public active deals (cached)
  Future<List<Deal>> getPublicDeals() async {
    final response = await http.get(
      Uri.parse('${ApiConfig.baseUrl}/deals/public'),
      headers: await _getHeaders(),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return (data['data'] as List)
        .map((json) => Deal.fromJson(json))
        .toList();
  }

  /// Get single deal by ID
  Future<Deal> getDeal(String id) async {
    final response = await http.get(
      Uri.parse('${ApiConfig.baseUrl}/deals/$id'),
      headers: await _getHeaders(),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return Deal.fromJson(data['data']);
  }

  /// Check deal availability
  Future<Map<String, dynamic>> checkDealAvailability(String id) async {
    final response = await http.get(
      Uri.parse('${ApiConfig.baseUrl}/deals/$id/availability'),
      headers: await _getHeaders(),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return data['data'];
  }

  /// Create a new deal (requires authentication)
  Future<Deal> createDeal({
    required String dealName,
    String? description,
    required double discountPercentage,
    required DateTime startDate,
    required DateTime endDate,
    bool isActive = true,
    String? serviceId,
    String? terms,
    int? maxUses,
  }) async {
    final response = await http.post(
      Uri.parse('${ApiConfig.baseUrl}/deals'),
      headers: await _getHeaders(requiresAuth: true),
      body: jsonEncode({
        'DealName': dealName,
        'Description': description,
        'DiscountPercentage': discountPercentage,
        'StartDate': startDate.toIso8601String().split('T')[0],
        'EndDate': endDate.toIso8601String().split('T')[0],
        'IsActive': isActive,
        'ServiceID': serviceId,
        'Terms': terms,
        'MaxUses': maxUses,
        'CurrentUses': 0,
      }),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return Deal.fromJson(data['data']);
  }

  /// Update a deal (requires authentication)
  Future<Deal> updateDeal(
    String id, {
    String? dealName,
    String? description,
    double? discountPercentage,
    DateTime? startDate,
    DateTime? endDate,
    bool? isActive,
    String? serviceId,
    String? terms,
    int? maxUses,
    int? currentUses,
  }) async {
    final body = <String, dynamic>{};
    
    if (dealName != null) body['DealName'] = dealName;
    if (description != null) body['Description'] = description;
    if (discountPercentage != null) {
      body['DiscountPercentage'] = discountPercentage;
    }
    if (startDate != null) {
      body['StartDate'] = startDate.toIso8601String().split('T')[0];
    }
    if (endDate != null) {
      body['EndDate'] = endDate.toIso8601String().split('T')[0];
    }
    if (isActive != null) body['IsActive'] = isActive;
    if (serviceId != null) body['ServiceID'] = serviceId;
    if (terms != null) body['Terms'] = terms;
    if (maxUses != null) body['MaxUses'] = maxUses;
    if (currentUses != null) body['CurrentUses'] = currentUses;

    final response = await http.put(
      Uri.parse('${ApiConfig.baseUrl}/deals/$id'),
      headers: await _getHeaders(requiresAuth: true),
      body: jsonEncode(body),
    );

    _handleError(response);

    final data = jsonDecode(response.body);
    return Deal.fromJson(data['data']);
  }

  /// Delete a deal (requires authentication)
  Future<void> deleteDeal(String id) async {
    final response = await http.delete(
      Uri.parse('${ApiConfig.baseUrl}/deals/$id'),
      headers: await _getHeaders(requiresAuth: true),
    );

    _handleError(response);
  }
}

// ============================================================================
// USAGE EXAMPLES IN FLUTTER WIDGETS
// ============================================================================

/*
// Example 1: Login Screen
class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _apiService = ApiService();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  bool _isLoading = false;

  Future<void> _login() async {
    setState(() => _isLoading = true);

    try {
      final authResponse = await _apiService.login(
        email: _emailController.text,
        password: _passwordController.text,
      );

      // Navigate to home screen
      Navigator.pushReplacementNamed(context, '/home');
      
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Welcome ${authResponse.user.name}!')),
      );
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Login failed: $e')),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Login')),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Column(
          children: [
            TextField(
              controller: _emailController,
              decoration: InputDecoration(labelText: 'Email'),
              keyboardType: TextInputType.emailAddress,
            ),
            TextField(
              controller: _passwordController,
              decoration: InputDecoration(labelText: 'Password'),
              obscureText: true,
            ),
            SizedBox(height: 20),
            _isLoading
                ? CircularProgressIndicator()
                : ElevatedButton(
                    onPressed: _login,
                    child: Text('Login'),
                  ),
          ],
        ),
      ),
    );
  }
}

// Example 2: Services List Screen
class ServicesScreen extends StatefulWidget {
  @override
  _ServicesScreenState createState() => _ServicesScreenState();
}

class _ServicesScreenState extends State<ServicesScreen> {
  final _apiService = ApiService();
  List<Service> _services = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadServices();
  }

  Future<void> _loadServices() async {
    try {
      final services = await _apiService.getPublicServices();
      setState(() {
        _services = services;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to load services: $e')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Our Services')),
      body: _isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              itemCount: _services.length,
              itemBuilder: (context, index) {
                final service = _services[index];
                return ListTile(
                  title: Text(service.name),
                  subtitle: Text('\$${service.price} • ${service.duration} min'),
                  trailing: Icon(Icons.arrow_forward_ios),
                  onTap: () {
                    // Navigate to service details
                  },
                );
              },
            ),
    );
  }
}

// Example 3: Deals Screen
class DealsScreen extends StatefulWidget {
  @override
  _DealsScreenState createState() => _DealsScreenState();
}

class _DealsScreenState extends State<DealsScreen> {
  final _apiService = ApiService();
  List<Deal> _deals = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadDeals();
  }

  Future<void> _loadDeals() async {
    try {
      final deals = await _apiService.getPublicDeals();
      setState(() {
        _deals = deals;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to load deals: $e')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Current Deals')),
      body: _isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              itemCount: _deals.length,
              itemBuilder: (context, index) {
                final deal = _deals[index];
                return Card(
                  margin: EdgeInsets.all(8.0),
                  child: ListTile(
                    title: Text(deal.dealName),
                    subtitle: Text(deal.description ?? ''),
                    trailing: Chip(
                      label: Text('${deal.discountPercentage}% OFF'),
                      backgroundColor: Colors.green,
                    ),
                  ),
                );
              },
            ),
    );
  }
}

// Example 4: Auth Check on App Start
class SplashScreen extends StatefulWidget {
  @override
  _SplashScreenState createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  final _apiService = ApiService();

  @override
  void initState() {
    super.initState();
    _checkAuth();
  }

  Future<void> _checkAuth() async {
    await Future.delayed(Duration(seconds: 2)); // Splash delay
    
    final isAuthenticated = await _apiService.isAuthenticated();
    
    if (isAuthenticated) {
      Navigator.pushReplacementNamed(context, '/home');
    } else {
      Navigator.pushReplacementNamed(context, '/login');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              'Luxe Hair Studio',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 20),
            CircularProgressIndicator(),
          ],
        ),
      ),
    );
  }
}
*/
