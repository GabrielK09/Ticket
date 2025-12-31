package frontEnd

import (
	"fmt"
	"log"
	"myDocker/pkg"
	"os"
	"strings"
)

type ByteSlic []byte

func (v ByteSlic) convertToString() string { return string(v) }

func getEnvLine(content, key string) (string, bool) {
	lines := strings.Split(content, "\n")

	for _, line := range lines {
		line = strings.TrimSpace(line)

		if line == "" || strings.HasPrefix(line, "#") {
			continue
		}

		parts := strings.SplitN(line, "=", 2)

		if len(parts) != 2 {
			continue
		}

		if parts[0] == key {
			return line, true
		}
	}

	return "", false
}

func ReadFile(paths ...string) (bool, error) {
	currentIp := pkg.GetLocalIP()

	path, err := pkg.CheckExistsPath(paths...)

	if err != nil {
		log.Println("Erro ao checar os caminhos:", err)
		return false, err
	}

	newPath := fmt.Sprintf("%s/.env", path)

	fileData, err := os.ReadFile(newPath)

	if len(fileData) == 0 {
		return false, nil

	}

	if err != nil {
		log.Printf("Erro ao ler o arquivo: %s", newPath)
		return false, err

	}

	strFileData := ByteSlic(fileData).convertToString()

	apiURL, apiURLok := getEnvLine(strFileData, "API_URL")
	apiService, apiServiceok := getEnvLine(strFileData, "API_SERVICES")

	if apiURLok && apiServiceok {
		apiURLValue := strings.Split(apiURL, "=")
		apiServiceValue := strings.Split(apiService, "=")

		log.Printf("Valores: 1: %s | 2: %s", apiURLValue[1], apiServiceValue[1])

		if strings.Contains(apiURLValue[1], currentIp.To16().String()) && strings.Contains(apiServiceValue[1], currentIp.To16().String()) {
			log.Printf("A .env atual:\n%s já tem o IP atual:\n%s, não vai trocar", strFileData, currentIp)
			return true, nil

		} else {
			log.Printf("A .env atual:\n%s não tem o IP atual:\n%s, vai trocar", strFileData, currentIp)
			return false, nil
		}

	} else {
		log.Printf("N tem ok")
		return false, nil
	}
}
