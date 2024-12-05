import math

# Número máximo de trabajadores por semana
max_workers = 10  # Límite razonable de trabajadores

# Función para calcular el costo por trabajador excedente en la semana i
def calcular_exceso_costo(trabajadores_asignados, requerimiento, c1):
    return c1 * max(0, trabajadores_asignados - requerimiento)

# Función para calcular el costo por contratar nuevos trabajadores en la semana i
def calcular_costo_contratacion(trabajadores_actuales, trabajadores_previos, c2_base, c2_var):
    if trabajadores_actuales > trabajadores_previos:
        return c2_base + c2_var * (trabajadores_actuales - trabajadores_previos)
    return 0

# Función para inicializar la tabla de programación dinámica
def inicializar_dp(dp, n):
    for x in range(max_workers + 1):
        dp[n][x] = 0  # No hay costo al final del proyecto

# Función para llenar la tabla de programación dinámica
def llenar_tabla_dp(dp, path, b, c1, c2_base, c2_var, n):
    for i in range(n - 1, -1, -1):
        for x_prev in range(max_workers + 1):
            for x_curr in range(b[i], max_workers + 1):
                # Calcular costos de exceso y contratación
                c1_cost = calcular_exceso_costo(x_curr, b[i], c1)
                c2_cost = calcular_costo_contratacion(x_curr, x_prev, c2_base, c2_var)
                cost = c1_cost + c2_cost + dp[i + 1][x_curr]

                if cost < dp[i][x_prev]:
                    dp[i][x_prev] = cost
                    path[i][x_prev] = x_curr

# Función para obtener la asignación óptima
def obtener_asignacion_optima(path, n):
    optimal_assignment = []
    current_workers = 0

    for i in range(n):
        current_workers = path[i][current_workers]
        optimal_assignment.append(current_workers)

    return optimal_assignment

# Función para imprimir los resultados
def imprimir_resultados(optimal_assignment, min_cost):
    print("La solución óptima es:")
    for i, workers in enumerate(optimal_assignment):
        print(f"Semana {i + 1}: {workers} trabajadores")
    print(f"El costo total es: ${min_cost:.2f}")

# Función principal
def main():
    # Leer el número de semanas
    n = int(input("Ingrese el número de semanas del proyecto: "))

    # Leer los requerimientos de trabajadores por semana
    b = []
    print("Ingrese los requerimientos mínimos de trabajadores por semana:")
    for i in range(n):
        b.append(int(input(f"Semana {i + 1}: ")))

    # Leer los costos de exceso (C1) y contratación (C2)
    c1 = int(input("Ingrese el costo por exceso (C1, por trabajador): "))
    c2_base = int(input("Ingrese el costo fijo de contratación (C2 base): "))
    c2_var = int(input("Ingrese el costo variable de contratación (C2 variable, por trabajador): "))

    # Crear tabla para DP y vector para rastrear decisiones óptimas
    dp = [[math.inf for _ in range(max_workers + 1)] for _ in range(n + 1)]
    path = [[-1 for _ in range(max_workers + 1)] for _ in range(n + 1)]

    # Inicializar la tabla DP
    inicializar_dp(dp, n)

    # Llenar la tabla DP
    llenar_tabla_dp(dp, path, b, c1, c2_base, c2_var, n)

    # Obtener la asignación óptima
    optimal_assignment = obtener_asignacion_optima(path, n)

    # El costo mínimo total es el valor en dp[0][0]
    min_cost = dp[0][0]

    # Imprimir los resultados
    imprimir_resultados(optimal_assignment, min_cost)

if __name__ == "__main__":
    main()
