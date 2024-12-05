#include <iostream>
#include <vector>
#include <limits>

using namespace std;

// Numero de semanas
const int max_workers = 10; // Limite razonable de trabajadores

// Funcion para calcular el costo por trabajador excedente en la semana i
double calcularExcesoCosto(int trabajadoresAsignados, int requerimiento, int c1) {
    return c1 * max(0, trabajadoresAsignados - requerimiento);
}

// Funcion para calcular el costo por contratar nuevos trabajadores en la semana i
double calcularCostoContratacion(int trabajadoresActuales, int trabajadoresPrevios, int c2_base, int c2_var) {
    return (trabajadoresActuales > trabajadoresPrevios) ? c2_base + c2_var * (trabajadoresActuales - trabajadoresPrevios) : 0;
}

// Funcion para inicializar la tabla de programacion dinamica
void inicializarDP(vector<vector<double>>& dp, int n) {
    for (int x = 0; x <= max_workers; ++x) {
        dp[n][x] = 0; // No hay costo al final del proyecto
    }
}

// Funcion para llenar la tabla de programacion dinamica
void llenarTablaDP(vector<vector<double>>& dp, vector<vector<int>>& path, const vector<int>& b, int c1, int c2_base, int c2_var, int n) {
    for (int i = n - 1; i >= 0; --i) {
        for (int x_prev = 0; x_prev <= max_workers; ++x_prev) {
            for (int x_curr = b[i]; x_curr <= max_workers; ++x_curr) {
                // Calcular costos de exceso y contratacion
                double C1 = calcularExcesoCosto(x_curr, b[i], c1);
                double C2 = calcularCostoContratacion(x_curr, x_prev, c2_base, c2_var);
                double cost = C1 + C2 + dp[i + 1][x_curr];

                if (cost < dp[i][x_prev]) {
                    dp[i][x_prev] = cost;
                    path[i][x_prev] = x_curr;
                }
            }
        }
    }
}

// Funcion para obtener la asignacion optima
vector<int> obtenerAsignacionOptima(const vector<vector<int>>& path, int n) {
    vector<int> optimal_assignment;
    int current_workers = 0;

    for (int i = 0; i < n; ++i) {
        current_workers = path[i][current_workers];
        optimal_assignment.push_back(current_workers);
    }

    return optimal_assignment;
}

// Funcion para imprimir los resultados
void imprimirResultados(const vector<int>& optimal_assignment, double min_cost) {
    cout << "La solucion optima es:\n";
    for (int i = 0; i < optimal_assignment.size(); ++i) {
        cout << "Semana " << (i + 1) << ": " << optimal_assignment[i] << " trabajadores\n";
    }
    cout << "El costo total es: $" << min_cost << endl;
}

// Funcion principal
int main() {
    int n;

    // Leer el numero de semanas
    cout << "Ingrese el numero de semanas del proyecto: ";
    cin >> n;

    vector<int> b(n); // Vector para los requerimientos de trabajadores

    // Leer los requerimientos de trabajadores por semana
    cout << "Ingrese los requerimientos minimos de trabajadores por semana:\n";
    for (int i = 0; i < n; ++i) {
        cout << "Semana " << (i + 1) << ": ";
        cin >> b[i];
    }

    int c1, c2_base, c2_var;

    // Leer los costos de exceso (C1) y contratacion (C2)
    cout << "Ingrese el costo por exceso (C1, por trabajador): ";
    cin >> c1;
    cout << "Ingrese el costo fijo de contratacion (C2 base): ";
    cin >> c2_base;
    cout << "Ingrese el costo variable de contratacion (C2 variable, por trabajador): ";
    cin >> c2_var;

    // Crear tabla para DP y vector para rastrear decisiones optimas
    vector<vector<double>> dp(n + 1, vector<double>(max_workers + 1, numeric_limits<double>::infinity()));
    vector<vector<int>> path(n + 1, vector<int>(max_workers + 1, -1));

    // Inicializar la tabla DP
    inicializarDP(dp, n);

    // Llenar la tabla DP
    llenarTablaDP(dp, path, b, c1, c2_base, c2_var, n);

    // Obtener la asignacion optima
    vector<int> optimal_assignment = obtenerAsignacionOptima(path, n);

    // El costo minimo total es el valor en dp[0][0]
    double min_cost = dp[0][0];

    // Imprimir los resultados
    imprimirResultados(optimal_assignment, min_cost);

    return 0;
}